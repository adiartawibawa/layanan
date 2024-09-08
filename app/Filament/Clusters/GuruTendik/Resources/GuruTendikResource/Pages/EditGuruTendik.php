<?php

namespace App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Pages;

use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuruTendik extends EditRecord
{
    protected static string $resource = GuruTendikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
