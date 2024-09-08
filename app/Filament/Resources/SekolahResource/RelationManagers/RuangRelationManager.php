<?php

namespace App\Filament\Resources\SekolahResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RuangRelationManager extends RelationManager
{
    protected static string $relationship = 'ruangs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('kode_ruang')
                    ->label('Kode'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Ruang'),
                Tables\Columns\TextColumn::make('bangunan.nama')
                    ->label('Bangunan'),
                Tables\Columns\TextColumn::make('registrasi_ruang')
                    ->label('Registrasi'),
                Tables\Columns\TextColumn::make('lantai_ke')
                    ->label('Lantai ke'),
                Tables\Columns\TextColumn::make('panjang')
                    ->label('Panjang'),
                Tables\Columns\TextColumn::make('lebar')
                    ->label('Lebar'),
                Tables\Columns\TextColumn::make('luas')
                    ->label('Luas'),
                Tables\Columns\TextColumn::make('kapasitas')
                    ->label('Kapasitas')
                    ->suffix(' orang'),
                Tables\Columns\TextColumn::make('luas_plester')
                    ->label('Luas plester'),
                Tables\Columns\TextColumn::make('luas_plafond')
                    ->label('Luas plafond'),
                Tables\Columns\TextColumn::make('luas_dinding')
                    ->label('Luas dinding'),
                Tables\Columns\TextColumn::make('luas_daun_jendela')
                    ->label('Luas daun jendela'),
                Tables\Columns\TextColumn::make('luas_daun_pintu')
                    ->label('Luas daun pintu'),
                Tables\Columns\TextColumn::make('panjang_kusen')
                    ->label('Panjang kusen'),
                Tables\Columns\TextColumn::make('luas_tutup_lantai')
                    ->label('Luas tutup lantai'),
                Tables\Columns\TextColumn::make('luas_instalasi_listrik')
                    ->label('Luas instalasi listrik'),
                Tables\Columns\TextColumn::make('jumlah_instalasi_listrik')
                    ->label('Jumlah instalasi listrik'),
                Tables\Columns\TextColumn::make('panjang_instalasi_air')
                    ->label('Panjang instalasi air'),
                Tables\Columns\TextColumn::make('jumlah_instalasi_air')
                    ->label('Jumlah instalasi air'),
                Tables\Columns\TextColumn::make('panjang_drainase')
                    ->label('Panjang drainase'),
                Tables\Columns\TextColumn::make('luas_finish_struktur')
                    ->label('Luas finish struktur'),
                Tables\Columns\TextColumn::make('luas_finish_plafond')
                    ->label('Luas finish plafond'),
                Tables\Columns\TextColumn::make('luas_finish_dinding')
                    ->label('Luas finish dinding'),
                Tables\Columns\TextColumn::make('luas_finish_kjp')
                    ->label('Luas finish kjp'),
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
