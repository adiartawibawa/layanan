<?php

namespace App\Livewire\Maps;

use Livewire\Component;

class BaseMap extends Component
{

    public $mapId = 'map'; // ID untuk elemen div peta
    public $height = '400px'; // Default height
    public $width = '100%';   // Default width

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
