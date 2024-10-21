<?php

namespace App\Livewire\Maps;

use Livewire\Attributes\On;
use Livewire\Component;

class Legend extends Component
{
    public $legendData = [];

    #[On('loadDataLegend')]
    public function loadData($geojson, $name, $groupedBy, $returnField)
    {
        $this->legendData[] = [
            'geojson' => $geojson,
            'name' => $name,
            'groupedBy' => $groupedBy,
            'returnField' => $returnField,
        ];
    }

    public function render()
    {
        return view('livewire.maps.legend', [
            'legendData' => $this->legendData,
        ]);
    }
}
