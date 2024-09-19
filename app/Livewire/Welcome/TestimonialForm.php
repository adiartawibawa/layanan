<?php

namespace App\Livewire\Welcome;

use App\Models\Testimonial;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class TestimonialForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $rating = 0; // Rating default 0

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        // 'name', 'email', 'message', 'rating', 'position'
        return $form->schema([
            TextInput::make('name')->label('Nama')->required(),
            TextInput::make('email')->label('Email')->email()->required(),
            TextInput::make('position')->label('Jabatan')->required(),
            Textarea::make('message')->label('Testimoni')->required(),
            SpatieMediaLibraryFileUpload::make('avatar')->label('Foto diri')->image()->collection('avatars')
        ])->statePath('data');
    }

    // Method untuk menangkap event dari komponen star rating
    #[On('ratingUpdated')]
    public function updateRating($rating)
    {
        $this->data['rating'] = $rating;
    }

    public function create()
    {
        $testimonial = Testimonial::create($this->form->getState());
        $this->form->model($testimonial)->saveRelationships();

        Notification::make()
            ->title('Terimakasih telah memberikan testimoni!')
            ->success()
            ->send();

        return $this->redirectRoute('welcome');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.welcome.testimonial-form');
    }
}
