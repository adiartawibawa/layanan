<?php

namespace App\Livewire\Welcome;

use App\Mail\ContactUsNotification;
use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class ContactUs extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('subject')->required(),
                Textarea::make('message')->required()
            ])
            ->statePath('data');
    }

    // public function create(): void
    // {
    //     try {
    //         ContactMessage::create($this->form->getState());
    //         $this->dispatch('sending-notif', data: $this->form->getState());
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    public function create(): Action
    {
        return Action::make('create')->label('Kirim')->action(function () {
            ContactMessage::create($this->form->getState());
            $this->dispatch('sending-notif', data: $this->form->getState());
            // Reinitialize the form to clear its data.
            $this->form->fill();
        })
            ->extraAttributes([
                "class" => "inline-flex items-center justify-center rounded-md bg-primary px-10 py-3 text-base font-medium text-white transition duration-300 ease-in-out hover:bg-red-dark"
            ])
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-envelope')
            ->modalHeading('Pesan berhasil dikirim')
            ->modalDescription('Pesan Anda telah berhasil dikirim. Tim kami akan segera menindaklanjuti pesan Anda.')
            ->modalSubmitAction(function (StaticAction $action) {
                $action->extraAttributes(['class' => 'inline-block rounded-md border border-transparent bg-primary text-base font-medium text-white transition hover:bg-red-dark']);
            })
            ->modalCloseButton(false);
    }

    #[On('sending-notif')]
    public function sendingContactNotification($data)
    {
        Mail::to(config('mail.from.address'))->send(new ContactUsNotification($data['name'], $data['email'], $data['subject'], $data['message']));
    }

    public function render()
    {
        return view('livewire.welcome.contact-us');
    }
}
