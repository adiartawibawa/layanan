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
        return $this->kecamatan->name;
    }

    public function getKabupatenNameAttribute()
    {
        return $this->kecamatan->kabupaten->name;
    }

    public function getProvinsiNameAttribute()
    {
        return $this->kecamatan->kabupaten->provinsi->name;
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
}
