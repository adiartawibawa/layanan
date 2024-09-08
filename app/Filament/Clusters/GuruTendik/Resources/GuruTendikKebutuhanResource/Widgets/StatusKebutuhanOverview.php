<?php

namespace App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource\Widgets;

use App\Filament\Clusters\GuruTendik\Resources\GuruTendikKebutuhanResource\Pages\ManageGuruTendikKebutuhans;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusKebutuhanOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ManageGuruTendikKebutuhans::class;
    }

    protected function getStats(): array
    {
        // Mendapatkan data dari model berdasarkan query yang diberikan.
        $data = $this->getPageTableRecords();

        // Mengelompokkan data berdasarkan kolom 'active' dan menghitung jumlahnya
        $groupedData = $data->groupBy('active')->map(function ($group) {
            return [
                'count' => $group->count(),
                'chart' => $group->sortBy('updated_at')->groupBy(function ($item) {
                    return Carbon::parse($item->updated_at)->format('Y');
                })->map->count()->values()
            ];
        });

        // Menghitung jumlah data aktif dan non-aktif menggunakan operator ternary
        // Jika terdapat data dengan 'active' = 1, maka itu adalah active
        // Jika terdapat data dengan 'active' != 1, maka itu adalah inactive
        $activeCount = $groupedData->has(1) ? $groupedData[1] : 0;
        $inactiveCount = $groupedData->has(0) ? $groupedData[0] : 0;

        // Periksa apakah 'count' dan 'chart' ada dalam $activeCount dan $inactiveCount
        // Jika ada, gunakan nilainya; jika tidak, gunakan nilai 0 atau array kosong
        return [

            Stat::make('Permohonan Kebutuhan Guru', isset($activeCount['count']) ? $activeCount['count'] : $activeCount)
                ->description('')
                ->chart(isset($activeCount['chart']) ? current($activeCount['chart']) : [])
                ->color('primary'),

            Stat::make('Kebutuhan Guru Terealisasi', isset($inactiveCount['count']) ? $inactiveCount['count'] : $inactiveCount)
                ->description('')
                ->chart(isset($inactiveCount['chart']) ? current($inactiveCount['chart']) : [])
                ->color('success'),

        ];
    }
}
