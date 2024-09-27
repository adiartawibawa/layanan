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
        // Render view dengan data sekolah
        return view('livewire.sekolah.detail-sekolah', [
            'sekolah' => $this->sekolah
        ]);
    }
}
