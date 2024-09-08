<?php

namespace App\Livewire\Permohonan;

use App\Models\LayananPermohonan;
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
        $this->datas = LayananPermohonan::with('histories', 'latestHistory')->get();
    }

    public function openModal($id)
    {
        $this->dispatch('openHistoryModal', permohonanId: $id);
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $permohonan = LayananPermohonan::find($arguments['permohonan']);

                $permohonan?->delete();

                $this->dispatch('permohonan-updated');

                Notification::make()
                    ->title('Berhasil dibatalkan')
                    ->success()
                    ->body('Pembatalan permohonan telah berhasil.')
                    ->send();
            });
    }

    #[On('permohonan-updated')]
    public function refreshData()
    {
        $this->datas = LayananPermohonan::with('histories', 'latestHistory')->get();
    }

    // public function deleteAction(): Action
    // {
    //     return Action::make('batalkan')
    //         ->requiresConfirmation()
    //         ->action(function (array $arguments) {
    //             $permohonan = LayananPermohonan::find($arguments['permohonanId']);

    //             dd($permohonan);
    //             // if ($permohonan) {
    //             //     $permohonan->delete();
    //             //     $this->datas = LayananPermohonan::with('histories', 'latestHistory')->get();
    //             //     $this->dispatch('notify', ['message' => 'Permohonan berhasil dibatalkan.']);
    //             // }
    //         });
    // }

    // public function batal($id)
    // {
    //     $this->permohonanId = LayananPermohonan::findOrFail($id);

    //     $this->deletePermohonan();
    //     // $permohonan->delete();

    //     // $this->datas = LayananPermohonan::with('histories', 'latestHistory')->get();

    //     // $this->dispatch('notify', ['message' => 'Permohonan berhasil dibatalkan.']);
    // }

    public function render()
    {
        return view('livewire.permohonan.list-permohonan')
            ->with([
                'datas' => $this->datas
            ]);
    }
}
