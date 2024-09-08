<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource\Pages;

use App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSarprasTanah extends EditRecord
{
    protected static string $resource = SarprasTanahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
