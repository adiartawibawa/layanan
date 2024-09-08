<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferensiRuang extends Model
{
    protected $table = 'referensi_ruangs';

    protected $fillable = [
        'kode_referensi',
        'referensi',
        'name',
        'desc',
    ];

    public static function defaultReferensiRuang()
    {
        return [
            ['referensi' => 'Ruang Kelas', 'name' => 'Ruang Kelas/Teori'],
            ['referensi' => 'Ruang Kepsek/Guru', 'name' => 'Ruang Kepsek'],
            ['referensi' => 'Ruang Kepsek/Guru', 'name' => 'Ruang Guru'],
            ['referensi' => 'Ruang Kepsek/Guru', 'name' => 'Ruang Kepsek'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Bahari'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Bahasa'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Biologi'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Fisika'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium IPA'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium IPS'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Komputer'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Kimia'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Multimedia'],
            ['referensi' => 'Ruang Laboratorium', 'name' => 'Laboratorium Nautika'],
            ['referensi' => 'Ruang Perpustakaan', 'name' => 'Ruang Perpustakaan'],
            ['referensi' => 'Ruang Perpustakaan', 'name' => 'Ruang Perpustakaan Multimedia'],
            ['referensi' => 'Ruang Praktek/Bengkel', 'name' => 'Bengkel'],
            ['referensi' => 'Ruang Praktek/Bengkel', 'name' => 'Ruang Praktik Kerja'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Keterampilan'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Serba Guna/Aula'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang UKS'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Praktik Kerja'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Bengkel'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Diesel'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Pameran'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Gambar'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Koperasi/Toko'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang BP/BK'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang TU'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang OSIS'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Kamar Mandi/WC Guru Laki-laki'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Kamar Mandi/WC Guru Perempuan'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Kamar Mandi/WC Siswa Laki-laki'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Kamar Mandi/WC Siswa Perempuan'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Gudang'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Ibadah'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Rumah Dinas Kepala Sekolah'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Rumah Dinas Guru'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Rumah Penjaga Sekolah'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Sanggar MGMP'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Sanggar PKG'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Asrama Siswa'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Unit Produksi'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Multimedia'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Pusat Belajar Guru'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Olahraga'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Orientasi dan Mobilitas (OM)'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Bina Wicara'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Bina Persepsi Bunyi dan Irama'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Bina Diri'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Bina Diri dan Bina Gerak'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Bina Pribadi dan Sosial'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Keterampilan'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Konseling/Asesmen'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Terapi'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Ruang Sirkulasi'],
            ['referensi' => 'Ruang Penunjang', 'name' => 'Kantin'],
        ];
    }
}
