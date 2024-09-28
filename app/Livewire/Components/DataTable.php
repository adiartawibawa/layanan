<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;

    public $columns = []; // Daftar kolom yang akan ditampilkan
    public $data = []; // Data untuk ditampilkan
    public $perPage = 10; // Jumlah item per halaman

    public function mount($columns, $data, $perPage = 10)
    {
        $this->columns = $columns;
        $this->data = $data;
        $this->perPage = $perPage;
    }

    public function updatingPerPage()
    {
        // Reset pagination ketika jumlah item per halaman berubah
        $this->resetPage();
    }

    public function render()
    {
        // Mengatur data yang ditampilkan sesuai dengan pagination
        $paginatedData = collect($this->data)->forPage($this->page, $this->perPage);

        return view('livewire.components.data-table', [
            'paginatedData' => $paginatedData,
        ]);
    }
}
