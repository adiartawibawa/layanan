<?php

namespace App\Livewire\Maps;

use Livewire\Attributes\On;
use Livewire\Component;

class Legend extends Component
{
    public $legendData = [];

    #[On('loadDataLegend')]
    public function loadData($geojson, $name, $groupedBy, $returnedField)
    {
        $this->legendData[] = [
            'geojson' => $geojson,
            'name' => $name,
            'groupedBy' => $groupedBy,
            'returnedField' => $returnedField,
        ];
    }

    public function render()
    {
        return view('livewire.maps.legend', [
            'legendData' => $this->legendData,
        ]);
    }
}
