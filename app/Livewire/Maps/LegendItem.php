<?php

namespace App\Livewire\Maps;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class LegendItem extends Component
{
    public $data; // Data GeoJSON dan informasi tambahan dari peta
    public $legendData = []; // Data hasil pengelompokan yang akan ditampilkan di legenda

    /**
     * Fungsi mount untuk inisialisasi komponen dengan data awal
     *
     * @param array $data
     */
    public function mount($data)
    {
        $this->data = $data;

        // Mendapatkan data GeoJSON dari URL yang diberikan
        $response = Http::get($data['geojson']);

        // Memastikan respons valid dan berisi data JSON
        if ($response->successful()) {
            $geojsonData = $response->json();

            // Mengelompokkan data berdasarkan field yang diberikan di $data
            $this->groupDataByField($geojsonData, $data);
        }
    }

    /**
     * Fungsi untuk mengelompokkan data GeoJSON secara dinamis berdasarkan filter
     *
     * @param array $geojsonData
     * @param array $filter
     */
    private function groupDataByField($geojsonData, $filter)
    {
        // Ambil field yang digunakan untuk pengelompokan dan field yang akan dikembalikan secara dinamis dari parameter $filter
        $groupedBy = $filter['groupedBy'] ?? null;
        $returnedField = $filter['returnedField'] ?? null;
        $name = $filter['name'] ?? 'Unknown'; // Nama layer, misal: Wilayah

        // Jika groupedBy atau returnedField tidak ada, hentikan proses
        if (!$groupedBy || !$returnedField) {
            return;
        }

        // Inisialisasi array kosong untuk legendData dengan key nama layer
        $this->legendData[$name] = [];

        // Inisialisasi array untuk memeriksa duplikasi
        $addedGroups = [];

        // Proses setiap fitur di dalam GeoJSON
        foreach ($geojsonData['features'] as $feature) {
            $properties = $feature['properties'];
            $styles = $feature['styles'];

            // Ambil nilai dari properti yang digunakan untuk pengelompokan
            $groupValue = $properties[$groupedBy] ?? null;
            $returnValue = $properties[$returnedField] ?? null;

            // Periksa apakah data sudah ada dalam array $addedGroups
            if ($groupValue && !in_array($groupValue, $addedGroups)) {
                // Jika belum ada, tambahkan ke array legendData
                $this->legendData[$name][] = [
                    'groupedBy' => $groupValue,
                    'returnedField' => $returnValue, // Menyimpan properti yang diminta
                    'styles' => $styles ?? [], // Menyimpan informasi ikon atau style lainnya
                ];

                // Tambahkan groupValue ke dalam array $addedGroups untuk menghindari duplikasi
                $addedGroups[] = $groupValue;
            }
        }
    }

    /**
     * Fungsi render untuk menampilkan view Livewire
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.maps.legend-item', [
            'legendData' => $this->legendData, // Mengirimkan data ke tampilan
        ]);
    }
}
