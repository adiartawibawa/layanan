<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuruTendik extends Model
{
    use SoftDeletes;
    use HasUuids;
    use HasOrganization;

    protected $fillable = [
        'user_id',
        'organization_id',
        'nama',
        'nik',
        'nuptk',
        'nip',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telp'
    ];

    protected $searchableColumns = ['nama', 'nuptk', 'nip'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tugas()
    {
        return $this->hasMany(GuruTendikTugas::class, 'guru_tendik_id', 'id');
    }

    public function kepegawaian()
    {
        return $this->hasOne(GuruTendikKepegawaian::class, 'guru_tendik_id', 'id');
    }
}
