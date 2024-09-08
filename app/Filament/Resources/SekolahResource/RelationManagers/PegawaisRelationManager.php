<?php

namespace App\Filament\Resources\SekolahResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaisRelationManager extends RelationManager
{
    protected static string $relationship = 'pegawais';

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
                Tables\Columns\TextColumn::make('nuptk')
                    ->label('NUPTK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Pegawai')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kepegawaian.status_kepegawaian')
                    ->label('Status Kepegawaian')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tugas.gtk.nip')
                    ->label('NIP')
                    ->searchable(),
                Tables\Columns\IconColumn::make('kepegawaian.is_kepsek')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Kepala Sekolah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepegawaian.jenis_ptk')
                    ->label('Jenis PTK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tugas.mapel_ajar')
                    ->label('Mapel Ajar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kepegawaian.bidang_studi_pendidikan')
                    ->label('Bidang Studi Pendidikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('no_telp')
                    ->label('No. Telepon'),
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
