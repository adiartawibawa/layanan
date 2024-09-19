<?php

namespace App\Livewire\Welcome;

use App\Models\Testimonial;
use Livewire\Component;

class TestimonialDisplay extends Component
{
    public $testimonials;

    public function mount()
    {
        // Ambil semua testimoni dari database
        $this->testimonials = Testimonial::with('media')->get();
    }

    public function render()
    {
        return view('livewire.welcome.testimonial-display');
    }
}
