<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Pages;

use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource;
use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Widgets\KondisiRuanganOverview;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSarprasRuang extends EditRecord
{
    protected static string $resource = SarprasRuangResource::class;

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
            KondisiRuanganOverview::class,
        ];
    }
}
