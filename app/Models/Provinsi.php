<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use Sluggable;

    protected $fillable = ['code', 'name', 'meta'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function cities()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_code', 'code');
    }

    public function districts()
    {
        return $this->hasManyThrough(
            Kecamatan::class,
            Kabupaten::class,
            'provinsi_code',
            'kabupaten_code',
            'code',
            'code'
        );
    }
}
