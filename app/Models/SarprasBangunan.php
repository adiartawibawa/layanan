<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SarprasBangunan extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;
    use HasOrganization;

    protected $table = 'bangunans';

    protected $fillable = [
        'organization_id',
        'jenis_prasarana_id',
        'tanah_id',
        'kode_bangunan',
        'nama',
        'panjang',
        'lebar',
        'luas_tapak_bangunan',
        'kepemilikan',
        'peminjam_meminjamkan',
        'nilai_aset',
        'jml_lantai',
        'tahun_bangun',
        'keterangan',
        'tanggal_sk_pemakai',
        'volume_pondasi',
        'volume_sloop',
        'panjang_kuda',
        'panjang_kaso',
        'panjang_reng',
        'luas_tutup_atap'
    ];

    public function prasarana(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class, 'jenis_prasarana_id', 'id');
    }

    public function tanah(): BelongsTo
    {
        return $this->belongsTo(SarprasTanah::class, 'tanah_id', 'id');
    }

    public function kondisis(): MorphMany
    {
        return $this->morphMany(SarprasKondisi::class, 'kondisi');
    }
}
