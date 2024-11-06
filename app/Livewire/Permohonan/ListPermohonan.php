<?php

namespace App\Livewire\Permohonan;

use App\Models\LayananPermohonan;
use App\Models\LayananPermohonanHistory;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class ListPermohonan extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $datas;
    public $permohonanId;

    public function mount()
    {
        $this->datas = LayananPermohonan::with('histories', 'latestHistory')->orderBy('created_at', 'desc')->get();
    }

    public function openModal($id)
    {
        $this->dispatch('openHistoryModal', permohonanId: $id);
    }

    public function batalAction(): Action
    {
        return Action::make('batal')
            ->label('Batalkan Permohonan')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $permohonan = LayananPermohonan::find($arguments['permohonan']);

                $permohonan?->delete();

                $this->dispatch('permohonan-updated');

                // Log the status in the LayananPermohonanHistory model.
                $this->datas->histories()->create([
                    'status' => LayananPermohonanHistory::DIBATALKAN,
                    'note' => "Permohonan telah dibatalkan oleh pemohon",
                ]);

                Notification::make()
                    ->title('Berhasil dibatalkan')
                    ->success()
                    ->body('Permohonan telah berhasil dibatalkan.')
                    ->send();
            });
    }

    #[On('permohonan-updated')]
    public function refreshData()
    {
        $this->datas = LayananPermohonan::with('histories', 'latestHistory')->get();
    }

    public function render()
    {
        return view('livewire.permohonan.list-permohonan')
            ->with([
                'datas' => $this->datas
            ]);
    }
}
