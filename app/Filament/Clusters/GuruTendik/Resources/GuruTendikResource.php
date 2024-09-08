<?php

namespace App\Filament\Clusters\GuruTendik\Resources;

use App\Filament\Clusters\GuruTendik as ClustersGuruTendik;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Pages;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\RelationManagers;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\RelationManagers\KepegawaianRelationManager;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\RelationManagers\TugasRelationManager;
use App\Models\GuruTendik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuruTendikResource extends Resource
{
    protected static ?string $model = GuruTendik::class;

    protected static ?string $cluster = ClustersGuruTendik::class;

    protected static ?string $slug = 'gtk';

    protected static ?string $pluralModelLabel = 'Guru & Tendik';

    protected static ?string $navigationLabel = 'Guru & Tendik';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('organization_id')
                //     ->relationship('organization', 'name')
                //     ->searchable()
                //     ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                //     ->preload(),
                // Forms\Components\TextInput::make('user_id')
                //     ->required()
                //     ->maxLength(36),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->label('Nomor Induk Kependudukan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nuptk')
                    ->label('NUPTK')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki - Laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\TextInput::make('no_telp')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required()
                    ->maxLength(13),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nuptk')
                    ->label('NUPTK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_telp')
                    ->label('Telp.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TugasRelationManager::class,
            KepegawaianRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuruTendiks::route('/'),
            'create' => Pages\CreateGuruTendik::route('/create'),
            'view' => Pages\ViewGuruTendik::route('/{record}'),
            'edit' => Pages\EditGuruTendik::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
