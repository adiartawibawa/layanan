<?php

namespace App\Filament\Resources\SekolahResource\Widgets;

use App\Filament\Resources\SekolahResource\Pages\ListSekolahs;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BentukanSekolahOverview extends BaseWidget
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
        $sekolahs = $this->getPageTableQuery()
            ->join('sekolah_bentuks', 'sekolahs.sekolah_bentuks_code', '=', 'sekolah_bentuks.code')
            ->get()
            ->groupBy('sekolah_bentuks_code')
            ->map(function ($items, $key) {
                return [
                    'code' => $items->first()->code,
                    'bentuk_name' => $items->first()->name,
                    'jumlah' => $items->count(),
                ];
            })
            ->sortBy(fn ($bentuk_name) => $bentuk_name)
            ->pluck(null, 'bentuk_name');

        // dd($sekolahs->first());
        foreach ($sekolahs as $key => $item) {
            $data[] = Stat::make($key, $item['jumlah']);
            // ->description($key)
            // ->color('primary');
        }

        return $data;
    }
}
