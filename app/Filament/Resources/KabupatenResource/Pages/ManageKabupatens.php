<?php

namespace App\Filament\Resources\KabupatenResource\Pages;

use App\Filament\Imports\KabupatenImporter;
use App\Filament\Resources\KabupatenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKabupatens extends ManageRecords
{
    protected static string $resource = KabupatenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Actions\ImportAction::make()
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->importer(KabupatenImporter::class),
        ];
    }
}
