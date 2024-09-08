<?php

namespace App\Models;

use App\Scopes\UserAuthScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LayananPermohonan extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'layanan_permohonan';

    protected $fillable = [
        'user_id',
        'layanan_id',
        'prasyarat',
        'formulir'
    ];

    protected $casts = [
        'prasyarat' => 'array',
        'formulir' => 'array',
    ];

    /**
     * The "booted" method of the model.
     * This method will be called automatically when the model is "booted".
     * Here, we are adding the UserScope globally to the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Adding the global scope to automatically restrict query results to the authenticated user's records
        static::addGlobalScope(new UserAuthScope);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id', 'id');
    }

    public function histories(): MorphMany
    {
        return $this->morphMany(LayananPermohonanHistory::class, 'permohonan', 'permohonan_type', 'permohonan_id');
    }

    /**
     * Get the latest history for the LayananPermohonan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestHistory()
    {
        return $this->morphOne(LayananPermohonanHistory::class, 'permohonan', 'permohonan_type', 'permohonan_id')->latestOfMany();
    }

    /**
     * Accessor to get the 'nama' attribute from the related 'layanan' model.
     *
     * @return string|null
     */
    public function getLayananNamaAttribute()
    {
        return $this->layanan ? $this->layanan->nama : null;
    }
}
