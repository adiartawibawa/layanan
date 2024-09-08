<?php

namespace App\Livewire\Layanan;

use App\Models\Layanan;
use Livewire\Component;

class ViewLayanan extends Component
{
    public Layanan $slug;

    public function render()
    {
        return view('livewire.layanan.view-layanan')
            ->with([
                'layanan' => $this->slug
            ]);
    }
}
