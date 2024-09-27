<?php

namespace App\Livewire\Maps;

use Livewire\Attributes\On;
use Livewire\Component;

class Point extends Component
{
    public $readOnly = true;
    public $latitude;
    public $longitude;
    public $layerId;
    // Properti untuk menyimpan URL ikon marker
    public $iconUrl;
    // Properti untuk menyimpan ID dari Leaflet Map
    public $mapInstance;

    public function mount($latitude = null, $longitude = null, $layerId = 'default-layer', $readOnly = true, $iconUrl = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->layerId = $layerId;
        $this->readOnly = $readOnly;
        $this->iconUrl = $iconUrl;
    }

    #[On('mapInitialized')]
    public function handleMapInitialized($mapId)
    {
        $this->mapInstance = $mapId;

        // Jika latitude dan longitude diset, tambahkan point ke layer dan pusatkan peta
        if ($this->latitude && $this->longitude) {
            $this->dispatch('add-point', [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'layerId' => $this->layerId,
                'mapId' => $mapId,
                'iconUrl' => $this->iconUrl,  // Kirim icon URL ke JavaScript
            ]);

            $this->dispatch('center-map', [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'mapId' => $mapId,
                'zoomLevel' => 15,
            ]);
        }

        if (!$this->readOnly) {
            $this->dispatch('enable-edit-mode', [
                'layerId' => $this->layerId,
                'mapId' => $mapId,
            ]);
        }
    }

    #[On('pointUpdated')]
    public function handlePointUpdated($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;

        $this->dispatch('center-map', [
            'latitude' => $lat,
            'longitude' => $lng,
            'mapId' => $this->mapInstance,
            'zoomLevel' => 15,
        ]);

        // Simpan perubahan ke database atau tindakan lainnya
    }

    public function render()
    {
        return view('livewire.maps.point');
    }
}
