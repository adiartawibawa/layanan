<?php

namespace App\Filament\Clusters\Sarpras\Resources;

use App\Filament\Clusters\Sarpras;
use App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource\Pages;
use App\Models\SarprasTanah;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SarprasTanahResource extends Resource
{
    protected static ?string $model = SarprasTanah::class;

    protected static ?string $cluster = Sarpras::class;

    protected static ?string $slug = 'tanah';

    protected static ?string $pluralModelLabel = 'Tanah';

    protected static ?string $navigationLabel = 'Tanah';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')
                    ->label('Sekolah')
                    ->relationship('organization', 'name')
                    ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('jenis_prasarana_id')
                    ->label('Jenis Prasarana')
                    ->relationship('prasarana', 'name')
                    ->required(),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Sertipikat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_sertifikat')
                    ->label('No. Sertipikat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('panjang')
                    ->label('Panjang Tanah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('lebar')
                    ->label('Lebar Tanah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('luas')
                    ->label('Luas Tanah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('luas_tersedia')
                    ->label('Luas Tanah Tersedia')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('kepemilikan')
                    ->label('Kepemilikan')
                    ->options([
                        'Milik' => 'Milik',
                        'Sewa' => 'Sewa',
                        'Pinjam' => 'Pinjam',
                        'Bukan Milik' => 'Bukan Milik',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('njop')
                    ->label('NJOP')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('denah_tanah')
                    ->label('Denah Tanah')
                    ->collection('denahs')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Sekolah')
                    ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                    ->searchable(),
                Tables\Columns\TextColumn::make('prasarana.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_sertifikat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('panjang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('luas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('luas_tersedia')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepemilikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('njop')
                    ->numeric()
                    ->sortable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSarprasTanahs::route('/'),
            'create' => Pages\CreateSarprasTanah::route('/create'),
            'view' => Pages\ViewSarprasTanah::route('/{record}'),
            'edit' => Pages\EditSarprasTanah::route('/{record}/edit'),
        ];
    }
}
