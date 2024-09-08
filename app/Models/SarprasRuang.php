<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SarprasRuang extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;
    use HasOrganization;

    protected $table = 'ruangs';

    protected $fillable = [
        'organization_id',
        'referensi_ruang_id',
        'bangunan_id',
        'kode_ruang',
        'nama',
        'registrasi_ruang',
        'lantai_ke',
        'panjang',
        'lebar',
        'luas',
        'kapasitas',
        'luas_plester',
        'luas_plafond',
        'luas_dinding',
        'luas_daun_jendela',
        'luas_daun_pintu',
        'panjang_kusen',
        'luas_tutup_lantai',
        'luas_instalasi_listrik',
        'jumlah_instalasi_listrik',
        'panjang_instalasi_air',
        'jumlah_instalasi_air',
        'panjang_drainase',
        'luas_finish_struktur',
        'luas_finish_plafond',
        'luas_finish_dinding',
        'luas_finish_kjp'
    ];

    public function referensiRuang(): BelongsTo
    {
        return $this->belongsTo(ReferensiRuang::class, 'referensi_ruang_id', 'id');
    }

    public function bangunan(): BelongsTo
    {
        return $this->belongsTo(SarprasBangunan::class, 'bangunan_id', 'id');
    }

    public function kondisis(): MorphMany
    {
        return $this->morphMany(SarprasKondisi::class, 'kondisi');
    }
}
