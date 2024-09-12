<?php

namespace App\Livewire\Welcome;

use App\Mail\SubscriptionConfirmation;
use App\Models\Subscription;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class NewsletterSubscription extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $email;

    protected $rules = [
        'email' => 'required|email|unique:subscriptions,email',
    ];

    public function subscribe(): Action
    {
        return Action::make('subscribe')
            ->model(Subscription::class)
            ->label('Berlangganan sekarang')
            ->extraAttributes([
                "class" => "inline-block rounded-md border border-transparent bg-secondary px-7 py-3 text-base font-medium text-white transition hover:bg-[#0BB489]"
            ])
            ->form([
                TextInput::make('email')->label('Masukkan alamat email')->email()->required()
            ])
            ->action(fn(Subscription $record) => $record->save())
            ->modalIcon('heroicon-o-envelope')
            ->modalHeading('Berlangganan Informasi Terbaru')
            ->modalDescription('Tetap terhubung dengan kami dan dapatkan informasi terbaru tentang program, kegiatan, dan berita penting dari Dinas Pendidikan.
                    Berlanggananlah untuk menerima update langsung di kotak masuk Anda.')
            ->modalSubmitActionLabel('Berlangganan sekarang')
            ->modalSubmitAction(function (StaticAction $action) {
                $action->extraAttributes(['class' => 'inline-block rounded-md border border-transparent bg-primary text-base font-medium text-white transition hover:bg-red-dark']);
            });
    }

    #[On('subscription')]
    public function sendMail($email)
    {
        Mail::to($email)->send(new SubscriptionConfirmation($email));
    }

    public function render()
    {
        return view('livewire.welcome.newsletter-subscription');
    }
}
