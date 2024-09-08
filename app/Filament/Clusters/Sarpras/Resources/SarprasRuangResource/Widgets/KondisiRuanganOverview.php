<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class KondisiRuanganOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Kondisi Terkini', $this->latestKondisi())
                ->description('Grafik kondisi terkini bangunan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->chartData())
                ->color('primary'),
        ];
    }

    protected function latestKondisi()
    {
        $latests = $this->record->kondisis();

        $kondisis = $latests->count() > 0 ? $latests->latest('tanggal_kondisi')->first()->kategori : 'Null';

        return $kondisis;
    }


    protected function chartData()
    {
        $kondisis = $this->record->kondisis()->oldest('tanggal_kondisi')->get();
        $data = [];
        foreach ($kondisis as $kondisi) {
            $tahun = date('Y', strtotime($kondisi->tanggal_kondisi));
            $data[$tahun] = 100 - $kondisi->prosentase;
        }

        return $data;
    }
}
