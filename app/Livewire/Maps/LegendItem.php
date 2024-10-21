<?php

namespace App\Livewire\Maps;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class LegendItem extends Component
{
    public $data;
    public $legendData = [];

    public function mount($data)
    {
        $this->data = $data;
        $response = Http::get($data['geojson']);
        $geojsonData = $response->json();
        $this->groupDataByField($geojsonData, $data['groupedBy'],);
    }

    private function groupDataByField($geojsonData)
    {
        foreach ($geojsonData['features'] as $feature) {
            $properties = $feature['properties'];
            $styles = $feature['styles'];
            $bentukCode = $properties['bentuk_code'];

            if (!isset($this->legendData[$bentukCode])) {
                $this->legendData[$bentukCode] = [
                    'bentuk' => $properties['bentuk'],
                    'icon' => $styles['icon'],
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.maps.legend-item', [
            // 'legendData' => $this->legendData,
        ]);
    }
}
