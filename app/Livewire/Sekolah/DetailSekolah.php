<?php

namespace App\Livewire\Sekolah;

use App\Models\Sekolah;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DetailSekolah extends Component
{
    public $npsn; // Properti untuk menyimpan NPSN
    public $sekolah; // Properti untuk menyimpan data sekolah yang ditemukan

    #[Layout('components.layouts.guest')]
    public function mount($npsn)
    {
        // Set nilai NPSN dari parameter yang diberikan
        $this->npsn = $npsn;

        // Cari sekolah berdasarkan NPSN beserta relasi-relasinya menggunakan Eager Loading
        $this->sekolah = Sekolah::with([
            'desa',        // Relasi desa
            'bentuk',      // Relasi bentuk sekolah
            'pegawais',    // Relasi pegawai
            'tanahs',      // Relasi tanah
            'ruangs',      // Relasi ruang
            'bangunans'    // Relasi bangunan
        ])->byNpsn($npsn)->first();
    }

    public function render()
    {
        // Ambil kolom untuk masing-masing relasi
        $tanahColumns = ['Nama Sertipikat', 'No.Sertipikat', 'NJOP', 'Panjang Tanah', 'Lebar Tanah', 'Luas Tanah', 'Luas Tanah Tersedia', 'Status Kepemilikan'];
        $bangunanColumns = ['Kode Bangunan', 'Nama Bangunan', 'Panjang Bangunan', 'Lebar Bangunan', 'Luas Tapak Bangunan', 'Kepemilikan Bangunan', 'Lantai Bangunan', 'Tahun Dibangun'];
        $ruangColumns = ['Kode Ruang', 'Nama Ruang', 'Panjang', 'Lebar', 'Luas', 'Kode Registrasi', 'Lokasi Ruang', 'Lokasi Lantai', 'Kapasitas'];

        return view('livewire.sekolah.detail-sekolah', [
            'sekolah' => $this->sekolah,
            'ruangColumns' => $ruangColumns,
            'ruangData' => $this->getRuangData(),
            'tanahColumns' => $tanahColumns,
            'tanahData' => $this->getTanahData(),
            'bangunanColumns' => $bangunanColumns,
            'bangunanData' => $this->getBangunanData(),
            'perPage' => request('perPage', 10),
        ]);
    }

    // Fungsi privat untuk mengambil data ruang
    private function getRuangData()
    {
        return $this->sekolah->ruangs->map(function ($ruang) {
            return [
                'kode_ruang' => $ruang->kode_ruang,
                'nama' => $ruang->nama,
                'panjang' => $ruang->panjang,
                'lebar' => $ruang->lebar,
                'luas' => $ruang->luas,
                'registrasi_ruang' => $ruang->registrasi_ruang,
                'bangunan' => $ruang->bangunan->nama,
                'lantai_ke' => $ruang->lantai_ke,
                'kapasitas' => $ruang->kapasitas,
            ];
        })->toArray();
    }

    // Fungsi privat untuk mengambil data tanah
    private function getTanahData()
    {
        return $this->sekolah->tanahs->map(function ($tanah) {
            return [
                'nama' => $tanah->nama,
                'no_sertifikat' => $tanah->no_sertifikat,
                'njop' => $tanah->njop,
                'panjang' => $tanah->panjang,
                'lebar' => $tanah->lebar,
                'luas' => $tanah->luas,
                'luas_tersedia' => $tanah->luas_tersedia,
                'status_kepemilikan' => $tanah->kepemilikan,
            ];
        })->toArray();
    }

    // Fungsi privat untuk mengambil data bangunan
    private function getBangunanData()
    {
        return $this->sekolah->bangunans->map(function ($bangunan) {
            return [
                'kode_bangunan' => $bangunan->kode_bangunan,
                'nama_bangunan' => $bangunan->nama,
                'panjang' => $bangunan->panjang,
                'lebar' => $bangunan->lebar,
                'luas_tapak_bangunan' => $bangunan->luas_tapak_bangunan,
                'kepemilikan' => $bangunan->kepemilikan,
                'jml_lantai' => $bangunan->jml_lantai,
                'tahun_bangun' => $bangunan->tahun_bangun,
            ];
        })->toArray();
    }
}
