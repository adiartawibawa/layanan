<?php

namespace App\Filament\Resources\Layanan;

use App\Filament\Resources\Layanan\PermohonanResource\Pages;
use App\Filament\Resources\Layanan\PermohonanResource\RelationManagers;
use App\Models\LayananPermohonan;
use App\Models\Permohonan;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PermohonanResource extends Resource
{
    protected static ?string $model = LayananPermohonan::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Pelayanan';

    protected static ?string $pluralModelLabel = 'Permohonan Layanan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('layanan_id')
                    ->relationship('layanan', 'nama')
                    ->required()
                    ->columnSpanFull(),
                Wizard::make([
                    Step::make('Prasyarat')
                        ->icon('heroicon-o-document-text')
                        ->description('Prasyarat permohonan yang diajukan')
                        ->schema(self::makeBlockBuilder('prasyarat', 'Prasyarat Layanan')),
                    Step::make('Formulir')
                        ->icon('heroicon-o-document-check')
                        ->description('Formulir permohonan yang diajukan')
                        ->schema(self::makeBlockBuilder('formulir', 'Formulir Layanan'))
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Permohonan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('layanan.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermohonans::route('/'),
            'create' => Pages\CreatePermohonan::route('/create'),
            'edit' => Pages\EditPermohonan::route('/{record}/edit'),
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
                            TextInput::make('content'),
                            Textarea::make('note')->label('Catatan'),
                            Toggle::make('valid')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()
                        ])->columns(2),
                    Block::make('textarea')
                        ->label(fn (?array $state): string => $state === null ? 'Paragraf' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->schema([
                            Textarea::make('content'),
                            Textarea::make('note')->label('Catatan'),
                            Toggle::make('valid')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()
                        ])->columns(2),
                    Block::make('datepicker')
                        ->label(fn (?array $state): string => $state === null ? 'Tanggal' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            DatePicker::make('content')->label('')->readOnly()->required(),
                            Textarea::make('note')->label('Catatan'),
                            Toggle::make('valid')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()
                        ])->columns(2),
                    Block::make('file')
                        ->label(fn (?array $state): string => $state === null ? 'Upload File' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-cloud-arrow-up')
                        ->schema([
                            FileUpload::make('content')->label('')
                                ->directory('permohonan/' . auth()->user()->id)
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('document-' . Str::slug(auth()->user()->name) . '-')
                                )
                                ->acceptedFileTypes(['application/pdf'])
                                ->openable()
                                ->deletable(false)
                                ->required(),
                            Textarea::make('note')->label('Catatan'),
                            Toggle::make('valid')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()
                        ])->columns(2),
                    Block::make('image')
                        ->label(fn (?array $state): string => $state === null ? 'Upload Gambar' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('content')->label('')
                                ->directory('permohonan/' . auth()->user()->id)
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('image-' . Str::slug(auth()->user()->name) . '-')
                                )
                                ->image()
                                ->deletable(false)
                                ->previewable()
                                ->required(),
                            Textarea::make('note')->label('Catatan'),
                            Toggle::make('valid')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline()
                        ])->columns(2),
                ])
                ->addable(false)
                ->reorderableWithDragAndDrop(false)
                ->deletable(false)
                ->blockNumbers(false)
        ];
    }
}
