<?php

namespace App\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class SekolahOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {
        $bangunan = $this->getBangunanSekolah();
        $ruang = $this->getRuangSekolah();

        return [
            // Nama Kepala Sekolah
            Stat::make('Kepala Sekolah', $this->getKepalaSekolah()),

            // Kondisi Sarpras Bangunan
            Stat::make('Sarpras Bangunan', $bangunan['jumlah'] . ' / ' . $bangunan['kondisi_terakhir']['kategori'])
                ->description('Kondisi rata-rata per-tahun ' . $bangunan['kondisi_terakhir']['tahun'])
                ->chart($bangunan['avg_kerusakan_per_tahun'])
                ->color('primary'),

            // Kondisi Sarpras Ruang
            Stat::make('Sarpras Ruangan', $ruang['jumlah'] . ' / ' . $ruang['kondisi_terakhir']['kategori'])
                ->description('Kondisi rata-rata per-tahun ' . $ruang['kondisi_terakhir']['tahun'])
                ->chart($ruang['avg_kerusakan_per_tahun'])
                ->color('primary'),
        ];
    }

    /**
     * Mendapatkan nama Kepala Sekolah dari model Sekolah saat ini.
     *
     * @return string|null Nama Kepala Sekolah atau null jika tidak ditemukan.
     */
    protected function getKepalaSekolah()
    {
        // Mengambil pegawai-pegawai terkait dengan sekolah
        $pegawais = $this->record->pegawais;
        // Array untuk menyimpan nama Kepala Sekolah
        $namaKepsek = [];
        // Iterasi melalui pegawais untuk mencari Kepala Sekolah
        foreach ($pegawais as $pegawai) {
            // Mengambil informasi kepegawaian
            $kepegawaian = $pegawai->kepegawaian;
            // Cek apakah pegawai adalah kepala sekolah (is_kepsek = true)
            if ($kepegawaian && $kepegawaian->is_kepsek) {
                // Menambahkan nama Kepala Sekolah ke dalam array
                $namaKepsek[] = $pegawai->nama;
            }
        }
        // Mengembalikan nama Kepala Sekolah pertama yang ditemukan, atau null jika tidak ada
        $nama = current($namaKepsek);

        return $nama ? $nama : 'undefined';
    }

    /**
     * Mendapatkan informasi bangunan sekolah, termasuk jumlah bangunan,
     * kondisi terakhir, dan rata-rata kerusakan per tahun.
     *
     * @return array Informasi bangunan sekolah.
     */
    protected function getBangunanSekolah()
    {
        // Mendapatkan objek sekolah.
        $sekolah = $this->record;

        // Menghitung jumlah bangunan.
        $jumlahBangunan = $sekolah->bangunans->count();

        // Menghitung rata-rata kerusakan per tahun.
        $kondisiBangunan = $this->avgKerusakanPerTahun($sekolah->bangunans->load('kondisis'));

        // Menyusun data hasil.
        $data = [
            'jumlah' => $jumlahBangunan,
            'kondisi_terakhir' => $this->kondisiTerakhir($kondisiBangunan),
            'avg_kerusakan_per_tahun' => $kondisiBangunan
        ];

        return $data;
    }

    /**
     * Mendapatkan informasi ruang sekolah, termasuk jumlah ruang,
     * kondisi terakhir, dan rata-rata kerusakan per tahun.
     *
     * @return array Informasi ruang sekolah.
     */
    protected function getRuangSekolah()
    {
        // Mendapatkan objek sekolah.
        $sekolah = $this->record;

        // Menghitung jumlah ruang.
        $jumlahRuang = $sekolah->ruangs->count();

        // Menghitung rata-rata kerusakan per tahun.
        $kondisiRuang = $this->avgKerusakanPerTahun($sekolah->ruangs->load('kondisis'));

        // Menyusun data hasil.
        $data = [
            'jumlah' => isset($jumlahRuang) ? $jumlahRuang : 'null',
            'kondisi_terakhir' => $this->kondisiTerakhir($kondisiRuang),
            'avg_kerusakan_per_tahun' => $kondisiRuang
        ];

        return $data;
    }

    /**
     * Menghitung rata-rata kerusakan per tahun berdasarkan kondisi record.
     *
     * @param array $kondisis Data kondisi record.
     * @return array Rata-rata kerusakan per tahun.
     */
    protected function avgKerusakanPerTahun($kondisis)
    {
        // Inisialisasi array untuk menyimpan pro sentase per tahun.
        $prosentasePerTahun = [];

        // Looping data kondisi record.
        foreach ($kondisis as $item) {
            // Looping kondisi record pada setiap item.
            foreach ($item['kondisis'] as $kondisi) {
                // Ekstrak tahun dari tanggal kondisi.
                $tahun = date('Y', strtotime($kondisi['tanggal_kondisi']));

                // Jika array pro sentase per tahun belum diinisialisasi.
                if (!isset($prosentasePerTahun[$tahun])) {
                    $prosentasePerTahun[$tahun] = [];
                }

                // Simpan pro sentase ke array pro sentase per tahun.
                $prosentasePerTahun[$tahun][] = $kondisi['prosentase'];
            }
        }

        // Hitung rata-rata per tahun.
        $rataRataPerTahun = [];
        foreach ($prosentasePerTahun as $tahun => $prosentases) {
            // Hitung rata-rata per tahun, jika tidak ada record, set nilai menjadi null.
            $rataRataPerTahun[$tahun] = count($prosentases) > 0 ? array_sum($prosentases) / count($prosentases) : null;
        }

        // Mengembalikan hasil rata-rata kerusakan per tahun.
        return $rataRataPerTahun;
    }

    /**
     * Menentukan kondisi terakhir berdasarkan data rata-rata per tahun.
     *
     * @param array $datas Data rata-rata per tahun.
     * @return array Informasi kondisi terakhir.
     */
    protected function kondisiTerakhir($datas)
    {
        // Mengurutkan data berdasarkan tahun secara ascending.
        asort($datas);

        // Mendapatkan tahun terakhir dan rata-rata terakhir.
        $latestYear = key($datas);
        $latestRataRata = current($datas);

        // Menentukan kategori berdasarkan rata-rata terakhir.

        if ($latestRataRata > 0 && $latestRataRata <= 30) {
            $kategori = 'Rusak Ringan';
        } elseif ($latestRataRata > 30 && $latestRataRata <= 45) {
            $kategori = 'Rusak Sedang';
        } elseif ($latestRataRata > 45 && $latestRataRata <= 100) {
            $kategori = 'Rusak Berat';
        } else {
            $kategori = 'Baik';
        }

        // Menyusun hasil dalam bentuk array.
        $result = [
            'tahun' => isset($latestYear) ? $latestYear : 'undefined',
            'rata_rata' => isset($latestRataRata) ? $latestRataRata : 'undefined',
            'kategori' => isset($kategori) ? $kategori : 'undefined',
        ];

        return $result;
    }
}
