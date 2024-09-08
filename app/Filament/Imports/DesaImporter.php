<?php

namespace App\Filament\Imports;

use App\Models\Desa;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DesaImporter extends Importer
{
    protected static ?string $model = Desa::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['required', 'max:10']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Desa
    {
        return Desa::firstOrNew([
            'code' => $this->data['code'],
            'name' => $this->data['name'],
            'kecamatan_code' => $this->data['kecamatan_code'],
            'meta' => json_encode(['lat' => $this->data['lat'], 'lon' => $this->data['lon'], 'kode_pos' => $this->data['kode_pos']]),
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your desa import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
