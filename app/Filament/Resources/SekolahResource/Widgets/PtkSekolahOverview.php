<?php

namespace App\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;

class PtkSekolahOverview extends ChartWidget
{
    public ?Model $record = null;

    protected static ?string $heading = 'Pendidik dan Tenaga Kependidikan';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    /**
     * Mengambil jumlah pegawai berdasarkan status kepegawaian dari sekolah.
     *
     * @return array|null Data jumlah pegawai berdasarkan status kepegawaian, atau null jika tidak ada pegawai.
     */
    protected function getPtkBySekolah()
    {
        // Mendapatkan daftar pegawai dari sekolah.
        $pegawais = $this->record->pegawais;

        // Jika tidak ada pegawai, kembalikan null.
        if ($pegawais->isEmpty()) {
            return null;
        }

        // Inisialisasi array untuk menyimpan jumlah pegawai berdasarkan status kepegawaian.
        $result = [];

        // Daftar status kepegawaian beserta warna yang sesuai.
        $statusColors = [
            'CPNS' => ['#FF6384', '#FFA07A'],  // Merah
            'Guru Honor Sekolah' => ['#36A2EB', '#9BD0F5'],  // Biru
            'Honor Daerah TK.II Kab/Kota' => ['#FFCE56', '#FFFF00'],  // Kuning
            'PNS' => ['#32CD32', '#98FB98'],  // Hijau
            'PNS_depag' => ['#8A2BE2', '#E6E6FA'],  // Ungu
            'PNS Diperbantukan' => ['#20B2AA', '#AFEEEE'],  // Aqua
            'PPPK' => ['#FFA500', '#FFD700'],  // Oranye
            'Tenaga Honor Sekolah' => ['#FF4500', '#FF8C00'],  // Merah tua
        ];

        // Iterasi melalui daftar pegawai dan menghitung jumlah pegawai berdasarkan status kepegawaian.
        foreach ($pegawais as $pegawai) {
            $statusKepegawaian = $pegawai->kepegawaian['status_kepegawaian'];

            // Jika status kepegawaian belum ada di result, tambahkan dengan nilai awal 1.
            if (!isset($result[$statusKepegawaian])) {
                $result[$statusKepegawaian] = 1;
            } else {
                // Jika sudah ada, tambahkan 1 ke jumlahnya.
                $result[$statusKepegawaian]++;
            }
        }

        // Urutkan array result berdasarkan kunci (label) secara alfabetic.
        ksort($result);

        // Format output sesuai dengan struktur yang diharapkan untuk chart.
        $datasets = [];
        foreach ($result as $status => $jumlah) {
            $datasets[] = [
                'label' => $status,
                'data' => [$jumlah],
                'backgroundColor' => $statusColors[$status][0], // Warna latar belakang
                'borderColor' => $statusColors[$status][1],     // Warna garis
            ];
        }

        // Labels untuk chart.
        $labels = ['Pegawai'];

        return compact('datasets', 'labels');
    }


    protected function getData(): array
    {
        $data = $this->getPtkBySekolah();

        return isset($data) ? $data : [];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
