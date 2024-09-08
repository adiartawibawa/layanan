<?php

namespace App\Filament\Resources\Layanan;

use App\Filament\Resources\Layanan\LayananResource\Pages;
use App\Filament\Resources\Layanan\LayananResource\RelationManagers;
use App\Models\Layanan;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Pelayanan';

    protected static ?string $pluralModelLabel = 'Layanan Dinas';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Layanan')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama layanan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('estimasi')
                            ->label('Estimasi waktu')
                            ->required()
                            ->numeric()
                            ->suffix('Hari')
                            ->default(1),
                        Forms\Components\Textarea::make('desc')
                            ->label('Deskripsi')
                            ->maxLength(65535),
                        SpatieMediaLibraryFileUpload::make('ilustrasi')
                            ->collection('ilustrasi-layanan')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                    ])->columnSpan(1)->collapsible(),
                Section::make('Panduan Layanan')
                    ->schema([
                        Repeater::make('panduan')
                            ->schema([
                                FileUpload::make('image_header')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                            ->prepend('sampul-'),
                                    )
                                    ->directory('panduan/sampuls/')
                                    ->image()
                                    ->label('Foto Sampul')
                                    ->required(fn (Page $livewire): bool => $livewire instanceof EditRecord),
                                TextInput::make('judul')
                                    ->label('Judul Panduan')
                                    ->required(fn (Page $livewire): bool => $livewire instanceof EditRecord),
                                RichEditor::make('konten')
                                    ->label('Panduan'),
                                FileUpload::make('file')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                            ->prepend('attachment-'),
                                    )
                                    ->directory('panduan/attachments/')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->label('File Attachment'),
                            ])
                            ->reorderableWithButtons(),
                    ])
                    ->columnSpan(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estimasi')
                    ->label('Estimasi Layanan')
                    ->suffix(' Hari')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Tersedia')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ketentuan')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->steps([
                        Step::make('Prasyarat')
                            ->icon('heroicon-o-document-text')
                            ->schema(self::makeBlockBuilder('prasyarat', 'Prasyarat Layanan')),
                        Step::make('Formulir')
                            ->icon('heroicon-o-document-check')
                            ->schema(self::makeBlockBuilder('formulir', 'Formulir Layanan')),
                    ])
                    ->fillForm(fn (Layanan $record): array => [
                        'prasyarat' => $record->prasyarat,
                        'formulir' => $record->formulir,
                    ])
                    ->action(function (array $data, Layanan $record): void {
                        $record->prasyarat = $data['prasyarat'];
                        $record->formulir = $data['formulir'];
                        $record->save();

                        Notification::make()
                            ->title('Saved successfully')
                            ->icon('heroicon-o-document-text')
                            ->iconColor('success')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }

    private static function makeBlockBuilder(string $title, string $desc): array
    {
        return [
            Builder::make($title)
                ->label($desc)
                ->blocks([
                    Block::make('string')
                        ->label(fn (?array $state): string => $state === null ? 'Jawaban Singkat' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-2')
                        ->schema([
                            TextInput::make('question')->label('Pertanyaan jawaban singkat')->live(onBlur: true)->required(),
                            TextInput::make('helperText')->label('Teks pembantu')->required(),
                            Hidden::make('content'),
                            // Toggle::make('required')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()->label('Wajib')->default(true),
                            Hidden::make('note'),
                            Hidden::make('valid')
                        ])->columns(2),
                    Block::make('textarea')
                        ->label(fn (?array $state): string => $state === null ? 'Paragraf' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->schema([
                            TextInput::make('question')->label('Pertanyaan jawaban panjang')->live(onBlur: true)->required(),
                            TextInput::make('helperText')->label('Teks pembantu')->required(),
                            Hidden::make('content'),
                            // Toggle::make('required')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()->label('Wajib')->default(true),
                            Hidden::make('note'),
                            Hidden::make('valid')
                        ])->columns(2),
                    Block::make('datepicker')
                        ->label(fn (?array $state): string => $state === null ? 'Tanggal' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            TextInput::make('question')->label('Pertanyaan tanggal')->live(onBlur: true)->required(),
                            TextInput::make('helperText')->label('Teks pembantu')->required(),
                            Hidden::make('content'),
                            // Toggle::make('required')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()->label('Wajib')->default(true),
                            Hidden::make('note'),
                            Hidden::make('valid')
                        ])->columns(2),
                    Block::make('file')
                        ->label(fn (?array $state): string => $state === null ? 'Upload File' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-cloud-arrow-up')
                        ->schema([
                            TextInput::make('question')->label('Pertanyaan upload file')->live(onBlur: true)->required(),
                            TextInput::make('helperText')->label('Teks pembantu')->required(),
                            Hidden::make('content'),
                            // Toggle::make('required')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()->label('Wajib')->default(true),
                            Hidden::make('note'),
                            Hidden::make('valid')
                        ])->columns(2),
                    Block::make('image')
                        ->label(fn (?array $state): string => $state === null ? 'Upload Gambar' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            TextInput::make('question')->label('Pertanyaan upload gambar/foto')->live(onBlur: true)->required(),
                            TextInput::make('helperText')->label('Teks pembantu')->required(),
                            Hidden::make('content'),
                            // Toggle::make('required')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()->label('Wajib')->default(true),
                            Hidden::make('note'),
                            Hidden::make('valid')
                        ])->columns(2),
                ])
                ->cloneable()
                ->blockNumbers(false)
        ];
    }
}
