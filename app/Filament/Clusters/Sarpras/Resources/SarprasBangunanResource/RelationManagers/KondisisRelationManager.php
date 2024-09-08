<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KondisisRelationManager extends RelationManager
{
    protected static string $relationship = 'kondisis';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori')
                    ->label('Kategori Kondisi')
                    ->options([
                        'Baik' => "Tanpa Kerusakan: 0%",
                        'Rusak Ringan' => "Rusak Ringan: 1% - 30%",
                        'Rusak Sedang' => "Rusak Sedang: 31% - 45%",
                        'Rusak Berat' => "Rusak Berat: 46% - 100%"
                    ])
                    ->required(),
                Forms\Components\TextInput::make('prosentase')
                    ->label('Prosentase Kerusakan')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_kondisi')
                    ->label('Tanggal Kondisi')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('kondisi-bangunan')
                    ->multiple()
                    ->label('Kondisi Bangunan')
                    ->collection('kondisi-bangunan'),
            ]);
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->record->kondisis()
            ->orderBy('tanggal_kondisi', 'desc');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('kategori')
            ->columns([
                Tables\Columns\TextColumn::make('kategori'),
                Tables\Columns\TextColumn::make('prosentase')->numeric()->suffix(' %'),
                Tables\Columns\TextColumn::make('tanggal_kondisi')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
