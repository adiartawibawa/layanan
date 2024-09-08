<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource\Pages;

use App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource;
use App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource\Widgets\SarprasTanahOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListSarprasTanahs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = SarprasTanahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SarprasTanahOverview::class
        ];
    }
}
