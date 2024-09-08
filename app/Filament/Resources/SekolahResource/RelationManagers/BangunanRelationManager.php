<?php

namespace App\Filament\Resources\SekolahResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BangunanRelationManager extends RelationManager
{
    protected static string $relationship = 'bangunans';

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
                Tables\Columns\TextColumn::make('kode_bangunan')
                    ->label('Kode Bangunan'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Bangunan'),
                Tables\Columns\TextColumn::make('panjang')
                    ->label('Panjang (m)'),
                Tables\Columns\TextColumn::make('lebar')
                    ->label('Lebar (m)'),
                Tables\Columns\TextColumn::make('luas_tapak_bangunan')
                    ->label('Luas tapak bangunan (m2)'),
                Tables\Columns\TextColumn::make('kepemilikan')
                    ->label('Kepemilikan'),
                Tables\Columns\TextColumn::make('peminjam_meminjamkan')
                    ->label('Peminjam/Meminjamkan'),
                Tables\Columns\TextColumn::make('nilai_aset')
                    ->label('Nilai Aset'),
                Tables\Columns\TextColumn::make('jml_lantai')
                    ->label('Jumlah Lantai'),
                Tables\Columns\TextColumn::make('tahun_bangun')
                    ->label('Tahun Bangun'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan'),
                Tables\Columns\TextColumn::make('tanggal_sk_pemakai')
                    ->label('Tanggal SK Pemakai'),
                Tables\Columns\TextColumn::make('volume_pondasi')
                    ->label('Volume Pondasi'),
                Tables\Columns\TextColumn::make('volume_sloop')
                    ->label('Volume sloop'),
                Tables\Columns\TextColumn::make('panjang_kuda')
                    ->label('Panjang kuda-kuda'),
                Tables\Columns\TextColumn::make('panjang_kaso')
                    ->label('Panjang kaso'),
                Tables\Columns\TextColumn::make('panjang_reng')
                    ->label('Panjang reng'),
                Tables\Columns\TextColumn::make('luas_tutup_atap')
                    ->label('Luas tutup atap'),
                Tables\Columns\TextColumn::make('tanah.nama')
                    ->label('Tanah'),
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
