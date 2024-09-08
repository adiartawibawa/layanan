<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Widgets;

use App\Filament\Clusters\Sarpras\Resources\SarprasBangunanResource\Pages\ListSarprasBangunans;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BangunanOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListSarprasBangunans::class;
    }

    protected function getStats(): array
    {
        return $this->kondisiBangunan();
    }

    protected function kondisiBangunan()
    {
        $bangunans = $this->getPageTableQuery()->get();

        // Menampilkan chart by year untuk setiap pembuatan bangunan
        $chart = $bangunans->groupBy('tahun_bangun')
            ->map(fn ($items, $year) => ['count' => count($items), 'year' => $year])
            ->sortBy('year')
            ->pluck('count')
            ->toArray();

        $data = [Stat::make('Bangunan Sarana Sekolah', $bangunans->count())
            ->description('Pertumbuhan per tahun')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart($chart)
            ->color('primary')];

        // Inisialisasi Array Kelompok Data
        $groupedData = [];
        // Iterasi Bangunan dan Kondisi
        foreach ($bangunans->flatMap->kondisis as $kondisi) {
            // Pengelompokan berdasarkan Kategori
            $kategori = $kondisi->kategori;
            // Pembuatan Array Kategori Baru (jika belum ada)
            $groupedData[$kategori][] = $kondisi;
        }

        // Inisialisasi array untuk menyimpan jumlah data untuk setiap tahun
        $jumlahDataPerTahun = [];
        foreach ($groupedData as $kategori => $dataKategori) {
            foreach ($dataKategori as $item) {
                // Ambil tahun dari tanggal_kondisi
                $tahun = date('Y', strtotime($item['tanggal_kondisi']));
                // Inisialisasi jumlahDataPerTahun jika belum ada
                $jumlahDataPerTahun[$kategori][$tahun] ??= 0;
                // Tambahkan 1 untuk setiap data
                $jumlahDataPerTahun[$kategori][$tahun]++;
            }
        }
        ksort($jumlahDataPerTahun);
        foreach ($jumlahDataPerTahun as $kategori => $value) {
            // dd($kategori);
            $data[] = Stat::make($kategori, $value[max(array_keys($value))])
                ->description('Kondisi Tahun ' . max(array_keys($value)))
                ->chart($value)
                ->color('primary');
        }

        return $data;
    }
}
