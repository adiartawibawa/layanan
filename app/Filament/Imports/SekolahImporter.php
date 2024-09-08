<?php

namespace App\Filament\Imports;

use App\Models\Desa;
use App\Models\Organization;
use App\Models\Sekolah;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class SekolahImporter extends Importer
{
    protected static ?string $model = Sekolah::class;

    public static function getColumns(): array
    {
        return [
            // ImportColumn::make('organisation_id')
            //     ->requiredMapping(),
            ImportColumn::make('sekolah_bentuks_code')
                ->label('Bentuk Pendidikan')
                ->guess(['bentuk_pendidikan'])
                ->requiredMapping()
                ->rules(['required', 'max:8']),
            ImportColumn::make('npsn')
                ->label('NPSN')
                ->requiredMapping()
                ->rules(['required', 'max:8']),
            ImportColumn::make('nama')
                ->label('Nama Sekolah')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('status')
                ->label('Status Sekolah')
                ->rules(['max:10']),
            ImportColumn::make('alamat')
                ->label('Alamat Sekolah')
                ->requiredMapping()
                ->rules(['required', 'max:65535']),
        ];
    }

    public function resolveRecord(): ?Sekolah
    {
        $organization = Organization::firstOrCreate([
            'name' => $this->data['nama'],
        ]);

        $desa = Desa::getCodeByDesaAndKecamatan($this->data['desa'], $this->data['kecamatan']);

        $sekolah = Sekolah::firstOrCreate(
            [
                'npsn' => $this->data['npsn'],
                'nama' => $this->data['nama']
            ],
            [
                'sekolah_bentuks_code' => $this->data['sekolah_bentuks_code'],
                'organization_id' => $organization->id,
                'status' => $this->data['status'],
                'alamat' => $this->data['alamat'],
                'desa_code' => $desa,
                'meta' => json_encode(['lat' => $this->data['lintang'], 'lon' => $this->data['bujur']]),
            ]
        );



        return $sekolah;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your sekolah import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
