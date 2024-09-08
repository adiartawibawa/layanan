<?php

namespace App\Livewire\Permohonan;

use App\Models\LayananPermohonan;
use Livewire\Attributes\On;
use Livewire\Component;

class HistoryPermohonan extends Component
{
    public $permohonan;
    public ?string $width = null;
    public ?string $icon = null;
    public ?string $iconColor = null;

    public function mount($width = null, $icon = null, $iconColor = null)
    {
        // $this->permohonanId = $permohonanId;
        // $this->permohonan = LayananPermohonan::with('histories')->find($this->permohonanId);

        $this->width = $width;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
    }

    #[On('openHistoryModal')]
    public function loadHistory($permohonanId)
    {
        $this->permohonan = LayananPermohonan::with('histories')->find($permohonanId);
        $this->dispatch('open-modal', id: 'history-modal');
    }

    public function render()
    {
        return view('livewire.permohonan.history-permohonan');
    }
}
