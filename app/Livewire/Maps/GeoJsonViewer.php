<?php

namespace App\Livewire\Maps;

use Livewire\Attributes\On;
use Livewire\Component;

class GeoJsonViewer extends Component
{
    public $geoJsonUrl;
    public $layerId;
    public $mapInstance;
    public $isPoint;

    public function mount($geoJsonUrl, $layerId = 'geojson-layer', $isPoint = false)
    {
        $this->geoJsonUrl = $geoJsonUrl;
        $this->layerId = $layerId;
        $this->isPoint = $isPoint;
    }

    #[On('mapInitialized')]
    public function handleMapInitialized($mapId)
    {
        $this->mapInstance = $mapId;

        $this->dispatch('loadGeoJson', [
            'geoJsonUrl' => $this->geoJsonUrl,
            'layerId' => $this->layerId,
            'mapId' => $mapId,
        ]);
    }

    public function render()
    {
        return view('livewire.maps.geo-json-viewer');
    }
}
