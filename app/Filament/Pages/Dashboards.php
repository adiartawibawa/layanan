<?php

namespace App\Filament\Pages;

use App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource\Widgets\StatusKebutuhanOverview;
use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Widgets\PtkChartOverview;
use App\Filament\Resources\SekolahResource\Widgets\PetaSekolahOverview;
use App\Filament\Widgets\TenancyInfoWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgetsColumns(): int|string|array
    {
        return 2;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
            TenancyInfoWidget::class,
            StatusKebutuhanOverview::class,
            PetaSekolahOverview::class,
            PtkChartOverview::class,
        ];
    }
}
