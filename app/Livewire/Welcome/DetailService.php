<?php

namespace App\Livewire\Welcome;

use App\Models\Layanan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DetailService extends Component
{
    public Layanan $slug;

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.welcome.detail-service')
            ->with(['layanan' => $this->slug]);
    }
}
