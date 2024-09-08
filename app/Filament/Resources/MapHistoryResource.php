<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MapHistoryResource\Pages;
use App\Filament\Resources\MapHistoryResource\RelationManagers;
use App\Models\MapHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MapHistoryResource extends Resource
{
    protected static ?string $model = MapHistory::class;

    protected static ?string $slug = 'peta';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('file_path')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('generated_year'),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('generated_year')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
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
            'index' => Pages\ManageMapHistories::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Manajemen Sekolah");
    }

    public static function getNavigationIcon(): ?string
    {
        return __('heroicon-o-map');
    }

    public static function getNavigationLabel(): string
    {
        return __("Peta");
    }

    public function getTitle(): string|Htmlable
    {
        return __("History Data GeoJSON");
    }

    public function getHeading(): string|Htmlable
    {
        return __("GeoJSON Data History");
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __("Manage and Access Historical GeoJSON Files Generated Over the Years");
    }
}
