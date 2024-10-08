<?php

namespace App\Livewire\Maps;

use Livewire\Attributes\On;
use Livewire\Component;

class GeoJsonSearch extends Component
{
    public $searchQuery;
    public $searchResults = [];   // Hasil pencarian yang akan ditampilkan

    public function updatedSearchQuery()
    {
        // Emit event untuk mengirimkan query pencarian ke komponen GeoJsonViewer yang sesuai
        $this->dispatch('searchGeoJson', $this->searchQuery);
    }

    #[On('updateSearchResults')]
    public function handleUpdateSearchResults($results)
    {
        $this->searchResults = $results['results'];

        // dd($this->searchResults);
    }

    public function render()
    {
        return view('livewire.maps.geo-json-search');
    }
}
