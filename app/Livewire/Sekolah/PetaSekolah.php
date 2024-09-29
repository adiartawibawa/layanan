<?php

namespace App\Livewire\Sekolah;

use App\Models\MapHistory;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PetaSekolah extends Component
{
    public $sekolahGeoJsonUrl;
    public $wilayahGeoJsonUrl;

    #[Layout('components.layouts.landing.landing')]
    public function mount()
    {
        // Ambil URL GeoJSON dari fungsi pada model MapHistory
        $this->sekolahGeoJsonUrl = MapHistory::getActiveSekolahMapUrl();
        $this->wilayahGeoJsonUrl = MapHistory::getActiveWilayahMapUrl();
    }

    public function render()
    {
        return view('livewire.sekolah.peta-sekolah', [
            'sekolahGeoJsonUrl' => $this->sekolahGeoJsonUrl,
            'wilayahGeoJsonUrl' => $this->wilayahGeoJsonUrl,
        ]);
    }
}
