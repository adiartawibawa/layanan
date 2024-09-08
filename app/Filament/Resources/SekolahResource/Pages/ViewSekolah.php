<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use App\Filament\Resources\SekolahResource;
use App\Filament\Resources\SekolahResource\Widgets\PtkSekolahOverview;
use App\Filament\Resources\SekolahResource\Widgets\SekolahOverview;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSekolah extends ViewRecord
{
    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SekolahOverview::class,
            PtkSekolahOverview::class,
        ];
    }
}
