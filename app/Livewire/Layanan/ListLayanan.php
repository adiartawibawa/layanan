<?php

namespace App\Livewire\Layanan;

use App\Models\Layanan;
use Livewire\Component;

class ListLayanan extends Component
{
    public $layanans;

    public function mount()
    {
        return $this->layanans = Layanan::all();
    }

    public function ajukanPermohonanLayanan($slug)
    {
        return $this->redirectRoute('permohonan.create', ['slug' => $slug]);
    }

    public function render()
    {
        return view('livewire.layanan.list-layanan');
    }
}
