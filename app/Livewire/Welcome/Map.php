<?php

namespace App\Livewire\Welcome;

use Livewire\Attributes\On;
use Livewire\Component;

class Map extends Component
{
    public $selectedPolygon = null;
    public $points;

    #[On('loadPoints')] // Tangkap event yang dipancarkan oleh JavaScript
    public function loadPoints($desaCode)
    {
        // Dapatkan data sekolah berdasarkan desaCode
        $this->points = \App\Models\MapHistory::getSekolahsWithinDesa($desaCode);

        // Kirim kembali data sekolah ke frontend dengan event 'pointsLoaded'
        $this->dispatch('pointsLoaded',  $this->points);
    }

    public function render()
    {
        return view('livewire.welcome.map');
    }
}
