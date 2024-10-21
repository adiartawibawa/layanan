<?php

namespace App\Livewire\Maps\Leaf;

use Livewire\Attributes\On;
use Livewire\Component;

class LLayer extends Component
{
    public $layers = [];

    #[On('layerAdded')]
    public function addLayer($name)
    {
        if (is_array($name)) {
            $name = implode(', ', $name); // Ubah menjadi string
        }

        // Tambahkan layer ke dalam array layers
        $this->layers[] = [
            'name' => $name,
            'visible' => true, // Default layer terlihat
        ];
    }

    public function toggleLayerVisibility($name)
    {
        foreach ($this->layers as &$layer) {
            if ($layer['name'] === $name) {
                // Toggle visibility
                $layer['visible'] = !$layer['visible'];

                // Dispatch event to toggle the layer visibility on the map
                $this->dispatch(
                    'toggleLayerVisibility',
                    name: $layer['name'],
                    visible: $layer['visible']
                );

                break;
            }
        }
    }

    public function render()
    {
        return view('livewire.maps.leaf.l-layer', ['layers' => $this->layers]);
    }
}
