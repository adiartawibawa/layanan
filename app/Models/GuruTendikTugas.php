<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use App\Concerns\Multitenantable;
use Illuminate\Database\Eloquent\Model;

class GuruTendikTugas extends Model
{
    use HasOrganization;

    protected $table = 'guru_tendik_tugas';

    protected $fillable = [
        'organization_id',
        'guru_tendik_id',
        'status_tugas',
        'mapel_ajar',
        'jam_mengajar',
        'tahun',
        'semester'
    ];

    public function gtk()
    {
        return $this->belongsTo(GuruTendik::class, 'guru_tendik_id', 'id');
    }
}
