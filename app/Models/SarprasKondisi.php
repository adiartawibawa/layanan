<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SarprasKondisi extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Sluggable;

    protected $fillable = [
        'kategori',
        'prosentase',
        'keterangan',
        'tanggal_kondisi'
    ];

    public function kondisi(): MorphTo
    {
        return $this->morphTo();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'kategori'
            ]
        ];
    }
}
