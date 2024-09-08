<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use App\Filament\Imports\SekolahImporter;
use App\Filament\Resources\SekolahResource;
use App\Filament\Resources\SekolahResource\Widgets\BentukanSekolahOverview;
use App\Filament\Resources\SekolahResource\Widgets\PetaSekolahOverview;
use App\Filament\Resources\SekolahResource\Widgets\StatusSekolahOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListSekolahs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Actions\ImportAction::make()
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->importer(SekolahImporter::class),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatusSekolahOverview::class,
            PetaSekolahOverview::class,
        ];
    }

    // protected function getFooterWidgets(): array
    // {
    //     return [
    //         BentukanSekolahOverview::class,
    //     ];
    // }
}
