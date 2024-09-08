<?php

namespace App\Livewire\Welcome;

use App\Models\Layanan;
use Livewire\Component;

class ListService extends Component
{

    public function allServices()
    {
        return Layanan::all();
    }


    public function render()
    {
        return view('livewire.welcome.list-service')->with([
            'services' => $this->allServices()
        ]);
    }
}
