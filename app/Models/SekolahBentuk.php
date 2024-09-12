<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class SekolahBentuk extends Model
{
    use Sluggable;

    protected $table = 'sekolah_bentuks';

    protected $fillable = ['code', 'name', 'desc'];

    protected $searchableColumns = ['code', 'name', 'desc'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public static function defaultSekolahBentuk()
    {
        return [
            ['code' => 'TPA', 'name' => 'Tempat Penitipan Anak', 'desc' => 'Tempat Penitipan Anak'],
            ['code' => 'KB', 'name' => 'Kelompok Belajar', 'desc' => 'Kelompok Belajar'],
            ['code' => 'TK', 'name' => 'Taman Kanak - Kanak', 'desc' => 'Taman Kanak - Kanak'],
            ['code' => 'SD', 'name' => 'Sekolah Dasar', 'desc' => 'Sekolah Dasar'],
            ['code' => 'SMP', 'name' => 'Sekolah Menengah Pertama', 'desc' => 'Sekolah Menengah Pertama'],
            ['code' => 'SKB', 'name' => 'Sanggar Kegiatan Belajar', 'desc' => 'Sanggar Kegiatan Belajar'],
            ['code' => 'PKBM', 'name' => 'Pusat Kegiatan Belajar Masyarakat', 'desc' => 'Pusat Kegiatan Belajar Masyarakat'],
        ];
    }

    public function sekolah()
    {
        return $this->hasMany(Sekolah::class, 'sekolah_bentuks_code', 'code');
    }
}
