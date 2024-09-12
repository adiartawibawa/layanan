<?php

namespace App\Livewire\Welcome;

use App\Models\Sekolah;
use App\Models\SekolahBentuk;
use Livewire\Component;

class SekolahOverview extends Component
{
    public $totalSekolah;
    public $sekolahBentukStatistics;
    public $pegawaiStatistics;
    public $tanahStatistics;
    public $ruangStatistics;
    public $bangunanStatistics;

    public function mount()
    {
        // Menghitung total sekolah
        $this->totalSekolah = Sekolah::count();

        // Menghitung jumlah sekolah berdasarkan bentuk
        $this->sekolahBentukStatistics = SekolahBentuk::withCount('sekolah')->get();
    }

    public function render()
    {
        return view('livewire.welcome.sekolah-overview');
    }
}
