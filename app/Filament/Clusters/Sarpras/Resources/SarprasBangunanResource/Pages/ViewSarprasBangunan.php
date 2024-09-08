<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Pages;

use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource;
use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Widgets\BangunanOverview;
use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Widgets\KondisiBangunanOverview;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSarprasBangunan extends ViewRecord
{
    protected static string $resource = SarprasBangunanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            KondisiBangunanOverview::class,
        ];
    }
}
