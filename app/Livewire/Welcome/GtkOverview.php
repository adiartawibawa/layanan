<?php

namespace App\Livewire\Welcome;

use App\Models\GuruTendik;
use App\Models\JenisPtk;
use Livewire\Component;

class GtkOverview extends Component
{
    public $totalGuruTendik;
    public $totalKepsek;
    public $jenisPtkStatistics;
    public $statusKepegawaianStatistics;

    public function mount()
    {
        // Menghitung total Guru dan Tenaga Kependidikan
        $this->totalGuruTendik = GuruTendik::count();

        // Menghitung total Kepala Sekolah
        $this->totalKepsek = GuruTendik::whereHas('kepegawaian', function ($query) {
            $query->where('is_kepsek', true);
        })->count();

        // Menghitung jumlah Guru berdasarkan jenis PTK
        // $this->jenisPtkStatistics = JenisPtk::withCount('guruTendik')->get();

        $this->statusKepegawaianStatistics = GuruTendik::with('kepegawaian')
            ->selectRaw('guru_tendik_kepegawaians.status_kepegawaian, COUNT(guru_tendik_kepegawaians.status_kepegawaian) as count')
            ->join('guru_tendik_kepegawaians', 'guru_tendiks.id', '=', 'guru_tendik_kepegawaians.guru_tendik_id')
            ->groupBy('guru_tendik_kepegawaians.status_kepegawaian')
            ->pluck('count', 'status_kepegawaian')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.welcome.gtk-overview');
    }
}
