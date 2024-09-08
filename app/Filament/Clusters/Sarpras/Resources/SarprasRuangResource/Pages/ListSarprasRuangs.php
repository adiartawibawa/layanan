<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Pages;

use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource;
use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Widgets\RuanganOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListSarprasRuangs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = SarprasRuangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RuanganOverview::class,
        ];
    }
}
