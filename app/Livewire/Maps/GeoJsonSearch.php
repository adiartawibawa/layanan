<?php

namespace App\Livewire\Maps;

use Livewire\Component;

class GeoJsonSearch extends Component
{
    public $searchQuery;

    public function updatedSearchQuery()
    {
        // Emit event untuk mengirimkan query pencarian ke komponen GeoJsonViewer
        $this->dispatch('searchGeoJson', $this->searchQuery);
    }

    public function render()
    {
        return view('livewire.maps.geo-json-search');
    }
}
