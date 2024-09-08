<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource\Widgets;

use App\Filament\Clusters\Sarpras\Resources\SarprasTanahResource\Pages\ListSarprasTanahs;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SarprasTanahOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListSarprasTanahs::class;
    }

    protected function getStats(): array
    {
        return $this->getStatusTanah();
    }

    protected function getStatusTanah()
    {
        $tanahs = $this->getPageTableQuery()->get()->groupBy('kepemilikan');
        $tanahs = $tanahs->sortBy(fn ($data, $kepemilikan) => $kepemilikan);

        $data = [];

        foreach ($tanahs as $item => $value) {
            $data[] = Stat::make('Tanah ' . $item, $value->count())
                ->description('Status Tanah ' . $item)
                ->color('primary');
        }

        return $data;
    }
}
