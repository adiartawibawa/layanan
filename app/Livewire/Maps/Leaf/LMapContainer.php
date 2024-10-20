<?php

namespace App\Livewire\Maps\Leaf;

use Livewire\Attributes\On;
use Livewire\Component;

class LMapContainer extends Component
{
    public $lat;
    public $lon;
    public $minZoom;
    public $maxZoom;
    public $height;
    public $width;
    public $geojsonLayers = [];

    public function mount($height = '400px', $width = '100%', $lon = 115.1762757, $lat = -8.6034424, $minZoom = 10, $maxZoom = 19)
    {
        $this->height = $height;
        $this->width = $width;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->minZoom = $minZoom;
        $this->maxZoom = $maxZoom;
    }

    #[On('searchGeojsonLayers')]
    public function searchGeojsonLayers($query)
    {
        dd($this->geojsonLayers);
        $this->dispatch('filter-geojson', ['query' => $query]);
    }

    public function addGeojsonLayer($geojson, $name)
    {
        // Menyimpan GeoJSON dengan nama layer
        $this->geojsonLayers[$name] = $geojson;

        // Mengirim event ke browser untuk menambah layer ke peta
        $this->dispatch('add-geojson', ['geojson' => $geojson, 'name' => $name]);

        // Emit event ke komponen pencarian untuk memperbarui layer GeoJSON
        $this->dispatch('updateGeojsonLayers', $this->geojsonLayers)->to(LMapSearch::class);
    }

    public function render()
    {
        return view('livewire.maps.leaf.l-map-container');
    }
}
