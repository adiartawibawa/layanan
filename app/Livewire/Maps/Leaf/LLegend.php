<?php

namespace App\Livewire\Maps\Leaf;

use Livewire\Attributes\On;
use Livewire\Component;

class LLegend extends Component
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
                $this->dispatch('toggleLayerVisibility', [
                    'geojsonUrl' => $name, // Mengirim URL atau nama GeoJSON sebagai key identifikasi
                    'visible' => $layer['visible']
                ]);

                // Debug: Lihat apa yang terjadi saat layer di-toggle
                logger()->info("Toggling layer {$name}, visibility: " . $layer['visible']);

                break;
            }
        }
    }

    public function render()
    {
        return view('livewire.maps.leaf.l-legend', ['layers' => $this->layers]);
    }
}
