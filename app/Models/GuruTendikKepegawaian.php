<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruTendikKepegawaian extends Model
{
    protected $table = 'guru_tendik_kepegawaians';

    protected $fillable = [
        'guru_tendik_id',
        'sk_cpns',
        'tmt_cpns',
        'sk_pengangkatan',
        'tmt_pengangkatan',
        'jenis_ptk',
        'pendidikan_terakhir',
        'bidang_studi_pendidikan',
        'bidang_studi_sertifikasi',
        'status_kepegawaian',
        'pangkat_gol_terakhir',
        'tmt_pangkat_terakhir',
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'is_kepsek',
    ];

    protected $casts = [
        'is_kepsek' => 'boolean',
    ];

    public function gtk()
    {
        return $this->belongsTo(GuruTendik::class, 'guru_tendik_id', 'id');
    }
}
