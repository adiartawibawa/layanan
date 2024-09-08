<?php

namespace App\Filament\Resources\ProvinsiResource\Pages;

use App\Filament\Imports\ProvinsiImporter;
use App\Filament\Resources\ProvinsiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProvinsis extends ManageRecords
{
    protected static string $resource = ProvinsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Actions\ImportAction::make()
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->importer(ProvinsiImporter::class),
        ];
    }
}
