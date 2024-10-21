<?php

namespace App\Livewire\Maps\Leaf;

use Livewire\Component;

class LPoint extends Component
{
    public $readOnly;
    public $latitude;
    public $longitude;
    public $iconUrl;

    public function mount($latitude, $longitude, $readOnly = true, $iconUrl = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->readOnly = $readOnly;
        $this->iconUrl = $iconUrl;
    }

    public function render()
    {
        return view('livewire.maps.leaf.l-point');
    }
}
