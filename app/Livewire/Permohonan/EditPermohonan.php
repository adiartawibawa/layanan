<?php

namespace App\Livewire\Permohonan;

use App\Models\LayananPermohonan;
use Livewire\Component;

class EditPermohonan extends Component
{
    public LayananPermohonan $permohonan;

    public function render()
    {
        return view('livewire.permohonan.edit-permohonan');
    }
}
