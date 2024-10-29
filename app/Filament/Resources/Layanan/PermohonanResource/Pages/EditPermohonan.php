<?php

namespace App\Filament\Resources\Layanan\PermohonanResource\Pages;

use App\Filament\Resources\Layanan\PermohonanResource;
use App\Models\LayananPermohonanHistory;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;


class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            $this->savedButton(),
        ];
    }

    public function savedButton()
    {
        return Action::make('saved')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            ->form([
                Textarea::make('note')
                    ->label('Catatan')
                    ->helperText('Berikan catatan mendetail kepada pemohon untuk proses selanjutnya')
                    ->required()
            ])
            ->action(function (array $data) {
                $this->approved($data['note']);
            })
            ->color('success')
            ->keyBindings(['mod+s'])
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-inbox-arrow-down')
            ->modalIconColor('primary')
            ->modalHeading('Permohonan Layanan')
            ->modalDescription('Silakan tinjau kembali detail permohonan layanan yang telah Anda periksa. Pastikan semua informasi sudah benar, lengkap dan sesuai.')
            ->modalSubmitActionLabel('Ya, setujui permohonan')
            ->modalCancelAction(false)
            ->extraModalFooterActions([
                Action::make('disapprove')
                    ->label('Tolak Permohonan')
                    ->form([
                        Textarea::make('note')
                            ->label('Catatan')
                            ->helperText('Berikan catatan mendetail kepada pemohon kenapa permohonan ditolak')
                            ->required()
                    ])
                    ->requiresConfirmation()
                    ->action(function (array $data) {
                        $this->disapproved($data['note']);
                    })
                    ->modalIcon('heroicon-o-x-circle')
                    ->color('primary')
                    ->cancelParentActions(),
            ]);
    }

    public function approved($note): void
    {
        $this->save();

        Notification::make()
            ->title('Berkas permohonan layanan ' . Str::lower($this->record->layanan->slug) . ' telah diperiksa dan valid.')
            ->success()
            ->viewData([
                'permohonanId' => $this->record->id,
                'permohonanStatus' => LayananPermohonanHistory::BERHASIL
            ])
            ->body($note)
            ->send()
            ->sendToDatabase($this->record->user()->firstOrFail());
    }

    public function disapproved($note): void
    {
        $this->save();
        Notification::make()
            ->title('Berkas permohonan layanan ' . Str::lower($this->record->layanan->slug) . ' telah diperiksa dan perlu ada perbaikan.')
            ->success()
            ->viewData([
                'permohonanId' => $this->record->id,
                'permohonanStatus' => LayananPermohonanHistory::DIKEMBALIKAN
            ])
            ->body($note)
            ->send()
            ->sendToDatabase($this->record->user()->firstOrFail());
    }
}
