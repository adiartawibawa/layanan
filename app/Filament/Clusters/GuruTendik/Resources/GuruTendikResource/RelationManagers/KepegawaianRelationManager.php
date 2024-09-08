<?php

namespace App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\RelationManagers;

use App\Models\GuruTendikKepegawaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KepegawaianRelationManager extends RelationManager
{
    protected static string $relationship = 'kepegawaian';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('guru_tendik_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sk_cpns')
                    ->label('SK CPNS'),
                Forms\Components\TextInput::make('tmt_cpns')
                    ->label('TMT CPNS'),
                Forms\Components\TextInput::make('sk_pengangkatan')
                    ->label('SK Pengangkatan'),
                Forms\Components\TextInput::make('tmt_pengangkatan')
                    ->label('TMT Pengangkatan'),
                Forms\Components\TextInput::make('jenis_ptk')
                    ->label('Jenis PTK'),
                Forms\Components\TextInput::make('pendidikan_terakhir')
                    ->label('Pendidikan Terakhir'),
                Forms\Components\TextInput::make('bidang_studi_pendidikan')
                    ->label('Bidang Studi Pendidikan'),
                Forms\Components\TextInput::make('bidang_studi_sertifikasi')
                    ->label('Bidang Studi Sertifikasi'),
                Forms\Components\Select::make('status_kepegawaian')
                    ->label('Status Kepegawaian')
                    ->options([
                        'CPNS' => 'CPNS',
                        'Guru Honor Sekolah' => 'Guru Honor Sekolah',
                        'Honor Daerah TK.II Kab/Kota' => 'Honor Daerah TK.II Kab/Kota',
                        'PNS' => 'PNS',
                        'PNS_depag' => 'PNS Depag',
                        'PNS Diperbantukan' => 'PNS Diperbantukan',
                        'PPPK' => 'PPPK',
                        'Tenaga Honor Sekolah' => 'Tenaga Honor Sekolah'
                    ]),
                Forms\Components\TextInput::make('pangkat_gol_terakhir')
                    ->label('Pangkat/Gol. Terakhir'),
                Forms\Components\TextInput::make('tmt_pangkat_terakhir')
                    ->label('TMT Pangkat Terakhir'),
                Forms\Components\TextInput::make('masa_kerja_tahun')
                    ->label('Masa Kerja Tahun'),
                Forms\Components\TextInput::make('masa_kerja_bulan')
                    ->label('Mas Kerja Bulan'),
                Forms\Components\Toggle::make('is_kepsek')
                    ->label('Kepala Sekolah'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (GuruTendikKepegawaian $record): string => "Data Kepegawaian {$record->gtk->nama}")
            ->columns([
                Tables\Columns\TextColumn::make('sk_cpns')
                    ->label('SK CPNS'),
                Tables\Columns\TextColumn::make('tmt_cpns')
                    ->label('TMT CPNS'),
                Tables\Columns\TextColumn::make('sk_pengangkatan')
                    ->label('SK Pengangkatan'),
                Tables\Columns\TextColumn::make('tmt_pengangkatan')
                    ->label('TMT Pengangkatan'),
                Tables\Columns\TextColumn::make('jenis_ptk')
                    ->label('Jenis PTK'),
                Tables\Columns\TextColumn::make('pendidikan_terakhir')
                    ->label('Pendidikan Terakhir'),
                Tables\Columns\TextColumn::make('bidang_studi_pendidikan')
                    ->label('Bidang Studi Pendidikan'),
                Tables\Columns\TextColumn::make('bidang_studi_sertifikasi')
                    ->label('Bidang Studi Sertifikasi'),
                Tables\Columns\TextColumn::make('status_kepegawaian')
                    ->label('Status Kepegawaian'),
                Tables\Columns\TextColumn::make('pangkat_gol_terakhir')
                    ->label('Pangkat/Gol. Terakhir'),
                Tables\Columns\TextColumn::make('tmt_pangkat_terakhir')
                    ->label('TMT Pangkat Terakhir'),
                Tables\Columns\TextColumn::make('masa_kerja_tahun')
                    ->label('Masa Kerja Tahun'),
                Tables\Columns\TextColumn::make('masa_kerja_bulan')
                    ->label('Mas Kerja Bulan'),
                Tables\Columns\IconColumn::make('is_kepsek')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Kepala Sekolah'),
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
