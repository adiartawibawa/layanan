<?php

namespace App\Filament\Resources\SekolahResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TanahRelationManager extends RelationManager
{
    protected static string $relationship = 'tanahs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_sertifikat')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('no_sertifikat')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Sertipikat'),
                Tables\Columns\TextColumn::make('no_sertifikat')
                    ->label('Nomor Sertipikat'),
                Tables\Columns\TextColumn::make('panjang')
                    ->label('Panjang (m)'),
                Tables\Columns\TextColumn::make('lebar')
                    ->label('Lebar (m)'),
                Tables\Columns\TextColumn::make('luas')
                    ->label('Luas lahan (m2)'),
                Tables\Columns\TextColumn::make('luas_tersedia')
                    ->label('Luas tersedia (m2)'),
                Tables\Columns\TextColumn::make('kepemilikan')
                    ->label('Kepemilikan'),
                Tables\Columns\TextColumn::make('njop')
                    ->label('NJOP')
                    ->money('IDR')
                    ->prefix('Rp. ')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    ),
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
