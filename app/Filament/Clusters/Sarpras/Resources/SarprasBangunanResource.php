<?php

namespace App\Filament\Clusters\Sarpras\Resources;

use App\Filament\Clusters\Sarpras;
use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Pages;
use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\RelationManagers;
use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\RelationManagers\KondisisRelationManager;
use App\Models\SarprasBangunan;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SarprasBangunanResource extends Resource
{
    protected static ?string $model = SarprasBangunan::class;

    protected static ?string $cluster = Sarpras::class;

    protected static ?string $slug = 'bangunan';

    protected static ?string $pluralModelLabel = 'Bangunan';

    protected static ?string $navigationLabel = 'Bangunan';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 1;

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
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('desc')
                    ])
                    ->editOptionForm([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('desc')
                    ])
                    ->required(),
                Forms\Components\Select::make('tanah_id')
                    ->label('No. Sertifikat Tanah')
                    ->relationship('tanah', 'no_sertifikat')
                    ->required(),
                Forms\Components\TextInput::make('kode_bangunan')
                    ->label('Kode Bangunan')
                    ->maxLength(25),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Bangunan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('panjang')
                    ->label('Panjang Bangunan')
                    ->required()
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar')
                    ->label('Lebar Bangunan')
                    ->required()
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_tapak_bangunan')
                    ->label('Luas Tapak Bangunan')
                    ->required()
                    ->default('-')
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
                Forms\Components\TextInput::make('peminjam_meminjamkan')
                    ->label('Peminjam/yang meminjamkan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nilai_aset')
                    ->label('Nilai Aset')
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('jml_lantai')
                    ->label('Jumlah Lantai')
                    ->required()
                    ->default('-')
                    ->numeric(),
                Forms\Components\DatePicker::make('tahun_bangun')
                    ->label('Tahun Dibangun')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_sk_pemakai')
                    ->label('Tanggal SK Pemakai')
                    ->required(),
                Forms\Components\TextInput::make('volume_pondasi')
                    ->label('Volume Pondasi')
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('volume_sloop')
                    ->label('Volume Sloop')
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_kuda')
                    ->label('Panjang Kuda - Kuda')
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_kaso')
                    ->label('Panjang Kaso')
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_reng')
                    ->label('Panjang Reng')
                    ->default('-')
                    ->numeric(),
                Forms\Components\TextInput::make('luas_tutup_atap')
                    ->label('Luas Tutup Atap')
                    ->default('-')
                    ->numeric(),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('foto_bangunan')
                    ->label('Foto Bangunan')
                    ->multiple()
                    ->reorderable()
                    ->collection('bangunans')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Sekolah')
                    ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                    ->searchable(),
                Tables\Columns\TextColumn::make('prasarana.name')
                    ->label('Jenis prasarana')
                    ->default('-')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_bangunan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanah.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('panjang')
                    ->default('-')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar')
                    ->default('-')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('luas_tapak_bangunan')
                    ->default('-')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepemilikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nilai_aset')
                    ->default('-')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jml_lantai')
                    ->default('-')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun_bangun')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_sk_pemakai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('peminjam_meminjamkan')
                    ->label('Peminjam/Meminjamkan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('volume_pondasi')
                    ->default('-')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('volume_sloop')
                    ->default('-')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('panjang_kuda')
                    ->default('-')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('panjang_kaso')
                    ->default('-')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('panjang_reng')
                    ->default('-')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_tutup_atap')
                    ->default('-')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            KondisisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSarprasBangunans::route('/'),
            'create' => Pages\CreateSarprasBangunan::route('/create'),
            'view' => Pages\ViewSarprasBangunan::route('/{record}'),
            'edit' => Pages\EditSarprasBangunan::route('/{record}/edit'),
        ];
    }
}
