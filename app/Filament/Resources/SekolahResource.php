<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Filament\Resources\SekolahResource\RelationManagers\BangunanRelationManager;
use App\Filament\Resources\SekolahResource\RelationManagers\PegawaisRelationManager;
use App\Filament\Resources\SekolahResource\RelationManagers\RuangRelationManager;
use App\Filament\Resources\SekolahResource\RelationManagers\TanahRelationManager;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $slug = 'sekolah';

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Manajemen Sekolah';

    protected static ?int $navigationSort = 1;

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->nama;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama', 'npsn'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->hidden(fn (): bool => !auth()->user()->hasRole(['super_admin', 'admin']))
                    ->preload(),
                Forms\Components\TextInput::make('npsn')
                    ->label('NPSN')
                    ->required()
                    ->maxLength(8),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Sekolah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('sekolah_bentuks_code')
                    ->label('Bentuk Sekolah')
                    ->relationship(name: 'bentuk', titleAttribute: 'code')
                    ->required(),
                Forms\Components\Select::make('desa_code')
                    ->label('Desa')
                    ->relationship(name: 'desa', titleAttribute: 'name')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->name} / {$record->getKecamatanNameAttribute()}";
                    })
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status Sekolah')
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                    ]),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->maxLength(65535),
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Foto Sekolah')
                    ->multiple()
                    // ->responsiveImages()
                    ->collection('sekolahs')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('meta')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bentuk.code')
                    ->label('Bentuk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desa.name')
                    ->searchable(),
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
            PegawaisRelationManager::class,
            TanahRelationManager::class,
            BangunanRelationManager::class,
            RuangRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'view' => Pages\ViewSekolah::route('/{record}'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
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
