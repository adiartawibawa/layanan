<?php

namespace App\Livewire\Maps;

use Livewire\Attributes\On;
use Livewire\Component;

class GeoJsonSearch extends Component
{
    public $searchQuery;
    public $searchResults = [];   // Hasil pencarian yang akan ditampilkan
    // public $layerId;              // Menyimpan layer ID untuk mencocokkan hasil

    // public function mount($layerId = null)
    // {
    //     $this->layerId = $layerId;
    // }

    public function updatedSearchQuery()
    {
        // Emit event untuk mengirimkan query pencarian ke komponen GeoJsonViewer yang sesuai
        $this->dispatch('searchGeoJson', $this->searchQuery);
    }

    #[On('updateSearchResults')]
    public function handleUpdateSearchResults($results, $layerId)
    {
        // if ($this->layerId === $layerId) {
        //     $this->searchResults = $results;
        // }

        dd($results);
    }

    public function render()
    {
        return view('livewire.maps.geo-json-search');
    }
}
