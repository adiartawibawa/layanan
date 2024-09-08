<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use App\Filament\Resources\SekolahResource;
use App\Filament\Resources\SekolahResource\Widgets\PtkSekolahOverview;
use App\Filament\Resources\SekolahResource\Widgets\SekolahOverview;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSekolah extends EditRecord
{
    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
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
