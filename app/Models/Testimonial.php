<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;

    protected $fillable = ['name', 'email', 'message', 'rating', 'position'];

    public function getAvatarUrl(): string
    {
        // Fallback image jika post tidak memiliki media terkait
        $fallbackImage = asset('images/avatar/male-avatar.png');

        // Mengambil URL gambar pertama dari koleksi 'images', atau fallback jika tidak ada
        return $this->getFirstMediaUrl('avatars') ?: $fallbackImage;
    }
}
