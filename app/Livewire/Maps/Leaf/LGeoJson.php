<?php

namespace App\Livewire\Maps\Leaf;

use Livewire\Attributes\On;
use Livewire\Component;

class LGeoJson extends Component
{
    public $geojson;
    public $name;
    public $model;
    public $searchable;
    public $searchableFields;
    public $isPoint;

    public function mount($geojson, $name, $model, $isPoint = false, $searchable = false, $searchableFields = [])
    {
        $this->geojson = $geojson;
        $this->name = $name;
        $this->model = $model;
        $this->isPoint = $isPoint;
        $this->searchable = $searchable;
        $this->searchableFields = $searchableFields;
    }

    #[On('loadLayerData')]
    public function loadLayerData()
    {

        $this->dispatch('layerDataLoaded', [
            'model' => $this->model,
            'searchable' => $this->searchable,
        ]);
    }

    #[On('toggleLayerVisibility')]
    public function handleToggleLayerVisibility($name, $visible)
    {
        if ($this->name === $name) {

            $this->dispatch(
                'toggleLayer',
                layerName: $this->name,
                visible: $visible
            );
        }
    }

    public function render()
    {
        return view('livewire.maps.leaf.l-geo-json');
    }
}
