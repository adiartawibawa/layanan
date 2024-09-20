<?php

namespace App\Livewire\Welcome;

use App\Models\Faq as ModelsFaq;
use App\Models\FaqCategory;
use Livewire\Component;

class Faq extends Component
{
    public $categories;
    public $activeCategory;
    public $faqs = [];

    public function mount()
    {
        // Ambil semua kategori
        $this->categories = FaqCategory::all();

        // Set kategori pertama sebagai aktif secara default
        $this->activeCategory = $this->categories->first()->id ?? null;

        // Ambil FAQ pertama kali
        if ($this->activeCategory) {
            $this->faqs = ModelsFaq::where('faq_category_id', $this->activeCategory)->get();
        }
    }

    public function setActiveCategory($categoryId)
    {
        // Set kategori aktif
        $this->activeCategory = $categoryId;

        // Ambil FAQ berdasarkan kategori yang dipilih
        $this->faqs = ModelsFaq::where('faq_category_id', $this->activeCategory)->get();
    }

    public function render()
    {
        return view('livewire.welcome.faq');
    }
}
