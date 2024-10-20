<?php

namespace App\Livewire\Maps;

use Livewire\Component;

class MapThumbnail extends Component
{
    public $meta;

    public function mount($meta)
    {
        $this->meta = $meta;
    }

    public function render()
    {
        return view('livewire.maps.map-thumbnail');
    }
}
