<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SarprasTanah extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;
    use HasOrganization;

    protected $table = 'tanahs';

    protected $fillable = [
        'organization_id',
        'jenis_prasarana_id',
        'nama',
        'no_sertifikat',
        'panjang',
        'lebar',
        'luas',
        'luas_tersedia',
        'kepemilikan',
        'njop',
        'keterangan'
    ];

    public function prasarana(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class, 'jenis_prasarana_id', 'id');
    }

    // public function sekolah(): BelongsTo
    // {
    //     return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    // }

    /**
     * Mendapatkan ID sekolah berdasarkan nama sekolah.
     *
     * @param string $namaSekolah
     * @return int|null
     */
    public static function getIdSekolahByNama($namaSekolah)
    {
        $sekolahId = Sekolah::where('nama', $namaSekolah)->value('id');

        return $sekolahId;
    }
}
