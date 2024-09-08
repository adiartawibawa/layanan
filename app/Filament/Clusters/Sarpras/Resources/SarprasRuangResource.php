<?php

namespace App\Filament\Clusters\Sarpras\Resources;

use App\Filament\Clusters\Sarpras;
use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Pages;
use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\RelationManagers\KondisisRelationManager;
use App\Models\SarprasRuang;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SarprasRuangResource extends Resource
{
    protected static ?string $model = SarprasRuang::class;

    protected static ?string $cluster = Sarpras::class;

    protected static ?string $slug = 'ruang';

    protected static ?string $pluralModelLabel = 'Ruang';

    protected static ?string $navigationLabel = 'Ruang';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?int $navigationSort = 2;

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
                Forms\Components\Select::make('referensi_ruang_id')
                    ->label('Referensi ruang')
                    ->relationship('referensiRuang', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('bangunan_id')
                    ->relationship('bangunan', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('kode_ruang')
                    ->maxLength(25),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('registrasi_ruang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('lantai_ke')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('panjang')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('lebar')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('luas')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('kapasitas')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('luas_plester')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_plafond')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_dinding')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_daun_jendela')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_daun_pintu')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_kusen')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_tutup_lantai')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_instalasi_listrik')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_instalasi_listrik')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_instalasi_air')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_instalasi_air')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_drainase')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_finish_struktur')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_finish_plafond')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_finish_dinding')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_finish_kjp')
                    ->numeric(),
                SpatieMediaLibraryFileUpload::make('foto_ruang')
                    ->label('Foto Kondisi Ruangan')
                    ->multiple()
                    ->reorderable()
                    ->collection('ruangs')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('referensiRuang.name')
                    ->label('Referensi ruang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_ruang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registrasi_ruang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bangunan.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lantai_ke')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('panjang')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lebar')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kapasitas')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Sekolah')
                    ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                    ->searchable(),
                Tables\Columns\TextColumn::make('luas_plester')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_plafond')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_dinding')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_daun_jendela')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_daun_pintu')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('panjang_kusen')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_tutup_lantai')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_instalasi_listrik')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jumlah_instalasi_listrik')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('panjang_instalasi_air')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jumlah_instalasi_air')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('panjang_drainase')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_finish_struktur')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_finish_plafond')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_finish_dinding')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_finish_kjp')
                    ->numeric()
                    ->default('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            KondisisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSarprasRuangs::route('/'),
            'create' => Pages\CreateSarprasRuang::route('/create'),
            'view' => Pages\ViewSarprasRuang::route('/{record}'),
            'edit' => Pages\EditSarprasRuang::route('/{record}/edit'),
        ];
    }
}
