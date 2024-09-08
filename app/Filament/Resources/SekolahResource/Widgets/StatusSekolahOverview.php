<?php

namespace App\Filament\Resources\SekolahResource\Widgets;

use App\Filament\Resources\SekolahResource\Pages\ListSekolahs;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusSekolahOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListSekolahs::class;
    }

    protected function getStats(): array
    {
        return $this->getStatusSekolah();
    }

    protected function getStatusSekolah()
    {
        $data = [];
        $sekolahs = $this->getPageTableQuery()->get()->groupBy('status');

        foreach ($sekolahs as $key => $value) {
            $data[] = Stat::make('Status ' . $key, $value->count())
                ->description('Sekolah di Kabupaten Badung')
                ->color('primary');
        }

        return $data;
    }
}
