<?php

namespace App\Models;

use App\Concerns\HasOrganization;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Sekolah extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasUuids;
    use SoftDeletes;
    use Sluggable;
    use HasOrganization;

    protected $fillable = [
        'npsn',
        'nama',
        'organization_id',
        'sekolah_bentuks_code',
        'status',
        'alamat',
        'desa_code',
        'meta'
    ];

    protected $searchableColumns = ['npsn', 'nama', 'status', 'desa.name', 'bentuk.name'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_code', 'code');
    }

    public function bentuk()
    {
        return $this->belongsTo(SekolahBentuk::class, 'sekolah_bentuks_code', 'code');
    }

    public function pegawais()
    {
        return $this->hasMany(GuruTendik::class, 'organization_id', 'organization_id');
    }

    public function tanahs()
    {
        return $this->hasMany(SarprasTanah::class, 'organization_id', 'organization_id');
    }

    public function ruangs()
    {
        return $this->hasMany(SarprasRuang::class, 'organization_id', 'organization_id');
    }

    public function bangunans()
    {
        return $this->hasMany(SarprasBangunan::class, 'organization_id', 'organization_id');
    }

    // Definisikan accessor untuk properti meta
    public function getMetaAttribute($value)
    {
        // Pastikan value tidak null dan lakukan decode JSON
        return $value ? json_decode($value, true) : null;
    }

    // Accessor untuk menggabungkan alamat lengkap
    public function getAlamatLengkapAttribute()
    {
        $desa = $this->desa ? $this->desa->name : 'Tidak ada desa';
        $kecamatan = $this->desa ? $this->desa->kecamatan->name : 'Tidak ada kecamatan'; // Mengasumsikan ada relasi ke kecamatan
        $kodePos = $this->desa ? $this->desa->kode_pos : 'Tidak ada kode pos'; // Mengasumsikan ada kolom kode pos di tabel desa

        // Format the address and capitalize the first letter of each word
        $alamatLengkap = "{$this->alamat}, Desa / Kelurahan {$desa}, Kecamatan {$kecamatan} - Kode Pos: {$kodePos}";

        return ucwords(strtolower($alamatLengkap));
    }

    /**
     * Scope a query to only include schools matching the given NPSN.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $npsn
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByNpsn($query, string $npsn)
    {
        return $query->where('npsn', $npsn);
    }

    /**
     * Perform a search based on the given keyword, matching on NPSN or other fields.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($query) use ($keyword) {
            $query->where('npsn', 'LIKE', "%{$keyword}%")
                ->orWhere('nama', 'LIKE', "%{$keyword}%")
                ->orWhere('status', 'LIKE', "%{$keyword}%");
        });
    }
}
