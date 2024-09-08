<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Layanan extends Model implements HasMedia
{
    use HasUuids;
    use Sluggable;
    use InteractsWithMedia;
    use HasOrganization;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'layanans';

    protected $fillable = [
        'nama',
        'slug',
        'estimasi',
        'desc',
        'panduan',
        'prasyarat',
        'formulir',
        'is_active'
    ];

    protected $casts = [
        'panduan' => 'array',
        'prasyarat' => 'array',
        'formulir' => 'array',
    ];

    // Override the route key name to use 'slug' instead of 'id'
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $appends = ['ilustrasi_url'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    public function getIlustrasiUrlAttribute()
    {
        return $this->getFirstMediaUrl('ilustrasi-layanan');
    }

    // Accessor untuk lima kalimat pertama dari paragraf
    public function getFirstFiveSentencesAttribute()
    {
        $text = $this->desc;

        // Memisahkan teks menjadi kalimat menggunakan regex
        $sentences = preg_split('/(?<!\.\.\.)(?<!\.\.\. )(?<=[.?!])\s+(?=[A-Z])/', $text);

        // Mengambil lima kalimat pertama
        $firstFiveSentences = array_slice($sentences, 0, 3);

        // Menggabungkan kembali menjadi paragraf
        return implode(' ', $firstFiveSentences);
    }
}
