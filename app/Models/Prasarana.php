<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prasarana extends Model
{
    protected $table = 'jenis_prasaranas';

    protected $fillable = [
        'kode_sarana',
        'name',
        'desc',
    ];

    public static function defaultJenisPrasarana()
    {
        return [
            [
                'kode_sarana' => 'P001',
                'name' => 'Ruang Sirkulasi',
                'desc' => 'Ruang Sirkulasi'
            ],
            [
                'kode_sarana' => 'P002',
                'name' => 'Lapangan',
                'desc' => 'Lapangan'
            ],
            [
                'kode_sarana' => 'P003',
                'name' => 'Parkir',
                'desc' => 'Parkir'
            ],
            [
                'kode_sarana' => 'P004',
                'name' => 'Kantin',
                'desc' => 'Kantin'
            ],
            [
                'kode_sarana' => 'P005',
                'name' => 'Lahan Kosong',
                'desc' => 'Lahan Kosong'
            ],
            [
                'kode_sarana' => 'P006',
                'name' => 'Tanah',
                'desc' => 'Tanah'
            ],
        ];
    }
}
