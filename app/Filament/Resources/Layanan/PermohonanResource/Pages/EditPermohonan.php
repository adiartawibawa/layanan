<?php

namespace App\Filament\Resources\Layanan\PermohonanResource\Pages;

use App\Filament\Resources\Layanan\PermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
