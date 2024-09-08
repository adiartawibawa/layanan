<?php

namespace App\Filament\Resources\KecamatanResource\Pages;

use App\Filament\Imports\KecamatanImporter;
use App\Filament\Resources\KecamatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKecamatans extends ManageRecords
{
    protected static string $resource = KecamatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Actions\ImportAction::make()
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->importer(KecamatanImporter::class),
        ];
    }
}
