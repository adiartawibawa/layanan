<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MapHistory extends Model
{
    protected $fillable = ['file_path', 'generated_year', 'is_active', 'type'];

    /**
     * Generate GeoJSON data and save it to storage and database.
     *
     * @return void
     */
    public static function generateGeoJson($type)
    {
        $features = [];

        switch ($type) {
            case 'sekolah':
                // Generate data untuk Sekolah
                $sekolahs = Sekolah::with(['desa', 'bentuk', 'pegawais', 'tanahs', 'ruangs', 'bangunans'])->get();

                foreach ($sekolahs as $sekolah) {
                    $meta = json_decode($sekolah->meta, true);
                    $latitude = isset($meta['lat']) ? floatval($meta['lat']) : null;
                    $longitude = isset($meta['lon']) ? floatval($meta['lon']) : null;

                    if ($latitude !== null && $longitude !== null) {
                        $features[] = [
                            'type' => 'Feature',
                            'geometry' => [
                                'type' => 'Point',
                                'coordinates' => [
                                    $longitude,
                                    $latitude,
                                ],
                            ],
                            'properties' => [
                                'npsn' => $sekolah->npsn,
                                'nama' => $sekolah->nama,
                                'status' => $sekolah->status,
                                'desa' => optional($sekolah->desa)->name,
                                'bentuk' => optional($sekolah->bentuk)->name,
                                'pegawai_count' => $sekolah->pegawais->count(),
                                'tanah_count' => $sekolah->tanahs->count(),
                                'ruang_count' => $sekolah->ruangs->count(),
                                'bangunan_count' => $sekolah->bangunans->count(),
                            ],
                        ];
                    }
                }
                break;

            case 'wilayah':
                // Generate data untuk Wilayah khusus Kabupaten BADUNG
                $desas = Desa::with('kecamatan.kabupaten.provinsi')
                    ->whereHas('kecamatan.kabupaten', function ($query) {
                        $query->where('code', '5103');
                    })
                    ->get();

                foreach ($desas as $desa) {
                    $meta = json_decode($desa->meta, true);
                    $geometry = isset($meta['geometry']) ? $meta['geometry'] : null;

                    if ($geometry !== null) {
                        $features[] = [
                            'type' => 'Feature',
                            'geometry' => $geometry,
                            'properties' => [
                                'desa_code' => $desa->code,
                                'desa_name' => $desa->name,
                                'kecamatan_name' => $desa->kecamatan->name,
                                'kabupaten_name' => $desa->kecamatan->kabupaten->name,
                                'provinsi_name' => $desa->kecamatan->kabupaten->provinsi->name,
                            ],
                        ];
                    } else {
                        Log::warning('No geometry found for Desa: ' . $desa->name);
                    }
                }
                break;

            default:
                throw new \Exception('Tipe peta tidak dikenali.');
        }

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        $directory = 'peta/' . $type;
        $fileName = $type . '_map_' . Carbon::now()->year . '.geojson';
        $filePath = $directory . '/' . $fileName;

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        Storage::disk('public')->put($filePath, json_encode($geojson, JSON_PRETTY_PRINT));

        self::create([
            'file_path' => $filePath,
            'generated_year' => Carbon::now(),
            'type' => $type,
        ]);
    }

    // Fungsi untuk mendapatkan URL file GeoJSON yang aktif
    public static function getActiveWilayahMapUrl()
    {
        $mapHistory = self::where('is_active', true)->where('type', 'wilayah')->first();
        return $mapHistory ? asset('storage/' . $mapHistory->file_path) : null;
    }

    public static function getSekolahsWithinDesa($desaCode)
    {
        // Dapatkan semua sekolah yang berada di dalam desa dengan desaCode yang sesuai
        $sekolahs = Sekolah::with(['desa', 'bentuk', 'pegawais', 'tanahs', 'ruangs', 'bangunans'])
            ->whereHas('desa', function ($query) use ($desaCode) {
                $query->where('desa_code', $desaCode);
            })
            ->get();

        foreach ($sekolahs as $sekolah) {
            $meta = json_decode($sekolah->meta, true);
            $latitude = isset($meta['lat']) ? floatval($meta['lat']) : null;
            $longitude = isset($meta['lon']) ? floatval($meta['lon']) : null;

            if ($latitude !== null && $longitude !== null) {
                $features[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $longitude,
                            $latitude,
                        ],
                    ],
                    'properties' => [
                        'npsn' => $sekolah->npsn,
                        'nama' => $sekolah->nama,
                        'status' => $sekolah->status,
                        'desa' => optional($sekolah->desa)->name,
                        'bentuk' => optional($sekolah->bentuk)->name,
                        'pegawai_count' => $sekolah->pegawais->count(),
                        'tanah_count' => $sekolah->tanahs->count(),
                        'ruang_count' => $sekolah->ruangs->count(),
                        'bangunan_count' => $sekolah->bangunans->count(),
                    ],
                ];
            }
        }

        // Buat GeoJSON untuk sekolah-sekolah tersebut
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        return json_encode($geojson);
    }
}
