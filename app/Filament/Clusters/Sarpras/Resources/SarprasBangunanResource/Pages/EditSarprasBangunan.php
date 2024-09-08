<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Pages;

use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource;
use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Widgets\KondisiBangunanOverview;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSarprasBangunan extends EditRecord
{
    protected static string $resource = SarprasBangunanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            KondisiBangunanOverview::class,
        ];
    }
}
