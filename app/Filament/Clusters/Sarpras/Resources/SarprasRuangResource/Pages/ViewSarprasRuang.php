<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Pages;

use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource;
use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Widgets\KondisiRuanganOverview;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSarprasRuang extends ViewRecord
{
    protected static string $resource = SarprasRuangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            KondisiRuanganOverview::class,
        ];
    }
}
