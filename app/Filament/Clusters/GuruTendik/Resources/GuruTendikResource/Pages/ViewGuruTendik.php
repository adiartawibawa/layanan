<?php

namespace App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Pages;

use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGuruTendik extends ViewRecord
{
    protected static string $resource = GuruTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
