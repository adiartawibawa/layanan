<?php

namespace App\Livewire\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;

    public $columns = [];
    public $data = [];
    public $perPage = 10;

    // Customizing the pagination view
    // protected $paginationTheme = 'tailwind';

    public function mount(array $columns, $data, $perPage = 10)
    {
        $this->columns = $columns;
        $this->data = $data;
        $this->perPage = $perPage;
    }

    public function render()
    {
        // Paginate the data collection
        $paginatedData = $this->paginate($this->data, $this->perPage);

        return view('livewire.components.data-table', [
            'columns' => $this->columns,
            'paginatedData' => $paginatedData,
        ]);
    }

    public function paginate($items, $perPage = null, $page = null, $options = [])
    {
        $perPage = $perPage ?: $this->perPage;
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?? 1);
        $items = collect($items);
        $total = $items->count();
        $results = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator($results, $total, $perPage, $page, $options);
    }
}
