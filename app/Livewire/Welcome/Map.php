<?php

namespace App\Livewire\Welcome;

use App\Models\MapHistory;
use Livewire\Attributes\On;
use Livewire\Component;

class Map extends Component
{

    #[On('loadPoints')] // Tangkap event yang dipancarkan oleh JavaScript
    public function loadPoints($desaCode)
    {
        // Dapatkan data sekolah berdasarkan desaCode
        $points = MapHistory::getSekolahsWithinDesa($desaCode);

        $this->dispatch('pointsLoaded', $points);

        // return $this->points;
    }

    public function render()
    {
        return view('livewire.welcome.map');
    }
}
