<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPtk extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'desc'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // Relasi ke GuruTendik
    // public function guruTendik()
    // {
    //     return $this->hasMany(GuruTendik::class, 'jenis_ptk', 'id');
    // }
}
