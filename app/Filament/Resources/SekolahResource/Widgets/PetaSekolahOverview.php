<?php

namespace App\Filament\Resources\SekolahResource\Widgets;

use App\Filament\Resources\SekolahResource\Pages\ListSekolahs;
use App\Models\Desa;
use App\Models\Kabupaten;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class PetaSekolahOverview extends Widget
{
    use InteractsWithPageTable;

    protected int | string | array $columnSpan = 'full';

    protected int $zoomLevel = 15;

    public $sekolah = null;
    public $desa = null;

    protected function getTablePage(): string
    {
        return ListSekolahs::class;
    }

    /**
     * Mengambil data sekolah dalam format GeoJSON.
     *
     * @return string
     */
    protected function allSekolahMap()
    {
        // Ambil data sekolah
        $sekolah = $this->getPageTableQuery()->get();

        // Inisialisasi array untuk menyimpan fitur-fitur GeoJSON
        $features = [];

        // Iterasi melalui setiap sekolah
        foreach ($sekolah as $index => $item) {
            // Ambil data meta dan koordinat dari sekolah
            $meta = $item->meta;
            $coordinates = [$meta['lon'], $meta['lat']];

            // Tentukan nama file ikon berdasarkan bentuk sekolah
            $iconFileName = 'school-' . strtolower($item->bentuk->code) . '.png';

            // Menyiapkan properti yang diperlukan untuk setiap fitur GeoJSON
            $properties = [
                "id" => $item->id,
                "npsn" => $item->npsn,
                "nama" => $item->nama,
                "slug" => $item->slug,
                "sekolah_bentuks_code" => $item->sekolah_bentuks_code,
                "status" => $item->status,
                "alamat" => $item->alamat,
                "icon" => asset('icon/' . $iconFileName), // Tambahkan properti icon
            ];

            // Menyiapkan fitur GeoJSON dengan properti dan geometri yang sesuai
            $feature = [
                "type" => "Feature",
                "properties" => $properties,
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => $coordinates
                ],
                "id" => $index
            ];

            // Menambahkan fitur GeoJSON ke dalam array fitur
            $features[] = $feature;
        }

        // Membuat objek GeoJSON dengan koleksi fitur-fiturnya
        $geojson = [
            "type" => "FeatureCollection",
            "features" => $features
        ];

        // Mengonversi objek GeoJSON ke dalam format string JSON
        return json_encode($geojson);
    }

    /**
     * Mengambil data desa dalam format GeoJSON.
     *
     * @return string
     */
    protected function getMapDesa()
    {
        // Ambil data kabupaten dengan kode '5103' beserta relasi kecamatan dan desa
        $kabupaten = Kabupaten::whereCode('5103')->with('kecamatans.desas')->firstOrFail();

        // Tentukan warna untuk setiap kecamatan
        $colors = [
            'KUTA' => '#37e7d3',
            'MENGWI' => '#96f69f',
            'ABIANSEMAL' => '#c7f984',
            'PETANG' => '#f9f871',
            'KUTA SELATAN' => '#1fdce5',
            'KUTA UTARA' => '#37e7d3',
        ];

        // Inisialisasi array untuk menyimpan fitur-fitur GeoJSON
        $features = [];

        // Iterasi melalui setiap kecamatan
        foreach ($kabupaten->kecamatans as $kecamatan) {
            // Ambil warna kecamatan berdasarkan namanya, jika tidak ada gunakan warna putih
            $color = $colors[$kecamatan->name] ?? '#ffffff';

            // Iterasi melalui setiap desa dalam kecamatan
            foreach ($kecamatan->desas as $desa) {
                // Ambil data geometri desa dari atribut 'meta'
                $coordinates = $desa->meta['geometry'];

                // Menambahkan properti yang diinginkan ke setiap fitur GeoJSON
                $properties = [
                    'id' => $desa->id,
                    'code' => $desa->code,
                    'name' => $desa->name,
                    'slug' => $desa->slug,
                    'color' => $color, // Menambahkan warna kecamatan
                    'kecamatan_name' => $desa->kecamatan->name, // Menambahkan nama kecamatan
                    'kabupaten_name' => $desa->kecamatan->kabupaten->name, // Menambahkan nama kabupaten
                    'created_at' => $desa->created_at,
                    'updated_at' => $desa->updated_at,
                ];

                // Menyiapkan fitur GeoJSON dengan properti dan geometri yang sesuai
                $feature = [
                    'type' => 'Feature',
                    'properties' => $properties,
                    'geometry' => $coordinates,
                ];

                // Menambahkan fitur GeoJSON ke dalam array fitur
                $features[] = $feature;
            }
        }

        // Membuat objek GeoJSON dengan koleksi fitur-fiturnya
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        // Mengonversi objek GeoJSON ke dalam format string JSON
        $geojsonString = json_encode($geojson);

        // Mengembalikan string JSON yang berisi data desa dalam format GeoJSON
        return $geojsonString;
    }

    public function render(): View
    {
        $this->sekolah = $this->allSekolahMap();

        $this->desa = $this->getMapDesa();

        return view('filament.resources.sekolah-resource.widgets.peta-sekolah-overview');
    }
}
