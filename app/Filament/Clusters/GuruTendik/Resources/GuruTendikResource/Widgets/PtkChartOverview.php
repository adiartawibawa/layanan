<?php

namespace App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Widgets;

use App\Filament\Clusters\GuruTendik\Resources\GuruTendikResource\Pages\ListGuruTendiks;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class PtkChartOverview extends ChartWidget
{
    use InteractsWithPageTable;

    protected static ?string $heading = 'Pendidik dan Tenaga Kependidikan';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    protected function getTablePage(): string
    {
        return ListGuruTendiks::class;
    }

    /**
     * Mengambil jumlah pegawai berdasarkan status kepegawaian dari model GuruTendik.
     *
     * @return array|null Data jumlah pegawai berdasarkan status kepegawaian, atau null jika tidak ada pegawai.
     */
    protected function getPtkByStatusKepegawaian()
    {
        // Mendapatkan daftar pegawai dari model GuruTendik.
        $pegawais = $this->getPageTableQuery()->get();

        // Jika tidak ada pegawai, kembalikan array kosong.
        if ($pegawais->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => ['Pegawai'],
            ];
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

        return $this->getPtkByStatusKepegawaian();
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
