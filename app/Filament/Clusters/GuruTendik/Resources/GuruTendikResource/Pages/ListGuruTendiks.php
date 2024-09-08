<?php

namespace App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Pages;

use App\Filament\Imports\GuruTendikImporter;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Widgets\PtkChartOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListGuruTendiks extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = GuruTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),

            Actions\ImportAction::make()
                ->label('Import')
                ->icon('heroicon-o-arrow-down-tray')
                ->importer(GuruTendikImporter::class),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PtkChartOverview::class,
        ];
    }
}
