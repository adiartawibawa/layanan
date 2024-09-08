<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LayananPermohonanHistory extends Model
{
    const DIBUAT = 0;
    const DIPROSES = 1;
    const DIKEMBALIKAN = 2;
    const BERHASIL = 3;
    const GAGAL = 4;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'layanan_permohonan_history';

    protected $fillable = [
        'status',
        'note',
        'permohonan_type',
        'permohonan_id'
    ];

    protected $appends = ['status_label'];

    public function histories(): MorphTo
    {
        return $this->morphTo('permohonan', 'permohonan_type', 'permohonan_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getCreatedAtMonthAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('F, Y');
    }

    // Accessor untuk mendapatkan teks status berdasarkan nilai konstan
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case self::DIBUAT:
                return 'Dibuat';
            case self::DIPROSES:
                return 'Diproses';
            case self::DIKEMBALIKAN:
                return 'Dikembalikan';
            case self::BERHASIL:
                return 'Berhasil';
            case self::GAGAL:
                return 'Gagal';
            default:
                return 'Unknown';
        }
    }
}
