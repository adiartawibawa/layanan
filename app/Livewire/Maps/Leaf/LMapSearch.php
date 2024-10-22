<?php

namespace App\Livewire\Maps\Leaf;

use Livewire\Attributes\On;
use Livewire\Component;

class LMapSearch extends Component
{
    public $query;
    public $mapLayers = [];
    public $searchResults = []; // Variable to hold the search results

    public function updatedQuery()
    {
        if (strlen($this->query) >= 4) {
            $this->searchResults = $this->searchMapLayers($this->query);
        } else {
            $this->searchResults = [];
        }
    }

    #[On('layerDataLoaded')]
    public function layerDataLoaded($data)
    {
        // Simpan data ke variabel penampung dengan informasi tambahan seperti searchable dan searchableFields
        $this->mapLayers[] = [
            'model' => $data['model'],
            'searchable' => $data['searchable'],
        ];
    }

    // Fungsi untuk melakukan pencarian pada data GeoJSON
    protected function searchMapLayers($query)
    {
        $results = [];

        foreach ($this->mapLayers as $layer) {
            // Jika layer bisa dicari (searchable)
            if ($layer['searchable']) {
                // Dapatkan model berdasarkan informasi
                $modelClass = "App\\Models\\" . $layer['model'];

                if (class_exists($modelClass)) {
                    // Lakukan pencarian menggunakan trait searchable
                    $results[$layer['model']] = $modelClass::search($query)->get();
                }
            }
        }

        return $results;
    }

    #[On('resetQuery')]
    public function resetQuery()
    {
        $this->query = '';
        $this->searchResults = []; // Juga reset hasil pencarian
    }

    public function render()
    {
        return view('livewire.maps.leaf.l-map-search');
    }
}
