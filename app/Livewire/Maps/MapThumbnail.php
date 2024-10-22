<?php

namespace App\Livewire\Maps;

use Livewire\Component;

class MapThumbnail extends Component
{
    public $meta;
    public $id;

    public function mount($meta, $id)
    {
        $this->meta = $meta;
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.maps.map-thumbnail');
    }
}
