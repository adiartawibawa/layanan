<?php

namespace App\Livewire\Maps;

use Livewire\Component;

class BaseMap extends Component
{
    public $mapId = 'map'; // ID untuk elemen div peta
    public $height; // Default height
    public $width;   // Default width

    public function mount($height = '400px', $width = '100%')
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function render()
    {
        return view('livewire.maps.base-map');
    }
}
