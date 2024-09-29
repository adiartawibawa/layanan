<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use Sluggable;

    protected $fillable = ['code', 'kecamatan_code', 'name', 'meta'];

    protected $searchableColumns = ['code', 'name', 'kecamatan.name'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_code', 'code');
    }

    public function getKecamatanNameAttribute()
    {
        return $this->kecamatan->name ?? null;
    }

    public function getKabupatenNameAttribute()
    {
        return $this->kecamatan->kabupaten->name ?? null;
    }

    public function getProvinsiNameAttribute()
    {
        return $this->kecamatan->kabupaten->provinsi->name ?? null;
    }

    /**
     * Mendapatkan code desa berdasarkan nama desa dan nama kecamatan.
     *
     * @param  string  $desaName
     * @param  string  $kecamatanName
     * @return string|null
     */
    public static function getCodeByDesaAndKecamatan($namaDesa, $namaKecamatan)
    {
        $desa = self::where('name', $namaDesa)
            ->whereHas('kecamatan', function ($query) use ($namaKecamatan) {
                $query->where('name', $namaKecamatan);
            })
            ->first();
        if ($desa) {
            return $desa->code;
        }
        return null;
    }

    // Property style untuk Polygon/LineString
    public function getStyleAttribute()
    {
        $colorMap = [
            'Kuta Selatan' => '#1fdce5',
            'Kuta' => '#37e7d3',
            'Kuta Utara' => '#66f0bb',
            'Mengwi' => '#96f69f',
            'Abiansemal' => '#c7f984',
            'Petang' => '#f9f871',
        ];

        return [
            'stroke' => '#364b44',
            'stroke-width' => 2,
            'stroke-opacity' => 1,
            'fill' => $colorMap[ucwords(strtolower($this->kecamatan->name ?? ''))] ?? '#364b44',
            'fill-opacity' => 0.6,
        ];
    }
}
