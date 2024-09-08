<?php

namespace App\Filament\Clusters\GuruTendik\Resources;

use App\Filament\Clusters\GuruTendik;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource\Pages;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource\RelationManagers;
use App\Models\GuruTendikKebutuhan;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuruTendikKebutuhanResource extends Resource
{
    protected static ?string $model = GuruTendikKebutuhan::class;

    protected static ?string $cluster = GuruTendik::class;

    protected static ?string $slug = 'kebutuhan';

    protected static ?string $pluralModelLabel = 'Kebutuhan Guru & Tendik';

    protected static ?string $navigationLabel = 'Kebutuhan Guru & Tendik';

    // protected static ?string $recordTitleAttribute = 'jenis_ptk_id';

    protected static ?string $modelLabel = 'Kebutuhan Guru & Tendik';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                    ->preload(),
                Forms\Components\Select::make('jenis_ptk_id')
                    ->label('Jenis PTK')
                    ->relationship('jenisPtk', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                    ])
                    ->required(),
                Forms\Components\TextInput::make('asn')
                    ->label('Ketersediaan ASN')
                    ->numeric(),
                Forms\Components\TextInput::make('non_asn')
                    ->label('Ketersediaan Non ASN')
                    ->numeric(),
                Forms\Components\TextInput::make('jml_sekarang')
                    ->label('Jumlah Tersedia Sekarang')
                    ->numeric(),
                Forms\Components\TextInput::make('jml_kurang')
                    ->label('Jumlah Kurang Guru')
                    ->numeric(),
                Forms\Components\Toggle::make('active')
                    ->default(true)
                    ->required(),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('30s')
            ->columns([
                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Sekolah')
                    ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenisPtk.name')
                    ->label('Jenis PTK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('asn')
                    ->label('ASN')
                    ->numeric(),
                Tables\Columns\TextColumn::make('non_asn')
                    ->label('Non ASN')
                    ->numeric(),
                Tables\Columns\TextColumn::make('jml_sekarang')
                    ->label('Kondisi Sekarang')
                    ->numeric(),
                Tables\Columns\TextColumn::make('jml_kurang')
                    ->label('Kebutuhan')
                    ->numeric(),
                Tables\Columns\IconColumn::make('active')
                    ->label('Aktif')
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ManageGuruTendikKebutuhans::route('/'),
        ];
    }
}
