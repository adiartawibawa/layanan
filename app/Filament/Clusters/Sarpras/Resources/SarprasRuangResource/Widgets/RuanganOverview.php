<?php

namespace App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Widgets;

use App\Filament\Clusters\Sarpras\Resources\SarprasRuangResource\Pages\ListSarprasRuangs;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RuanganOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListSarprasRuangs::class;
    }

    protected function getStats(): array
    {
        return $this->kondisiRuangan();
    }

    protected function kondisiRuangan()
    {
        $ruangs = $this->getPageTableQuery()->get();

        // Menampilkan chart by year untuk setiap pembuatan Ruangan
        $chart = $ruangs->groupBy('tahun_bangun')
            ->map(fn ($items, $year) => ['count' => count($items), 'year' => $year])
            ->sortBy('year')
            ->pluck('count')
            ->toArray();

        $data = [Stat::make('Ruangan Sarana Sekolah', $ruangs->count())
            ->description('Pertumbuhan per tahun')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart($chart)
            ->color('primary')];

        // Inisialisasi Array Kelompok Data
        $groupedData = [];
        // Iterasi Ruangan dan Kondisi
        foreach ($ruangs->flatMap->kondisis as $kondisi) {
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
