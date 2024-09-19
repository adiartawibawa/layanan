<?php

namespace App\Livewire\Components;

use Livewire\Component;

class StarRating extends Component
{
    public $rating = 0; // Rating saat ini
    public $maxRating = 5; // Jumlah bintang maksimal
    public $readOnly = false; // Jika hanya menampilkan rating, tanpa interaksi
    public $hoverRating; // Nilai rating yang di-hover
    public $styleClass = ' '; // Class untuk ukuran bintang

    public function mount($rating = 0, $maxRating = 5, $readOnly = false, $styleClass = 'w-8 h-8')
    {
        $this->rating = $rating;
        $this->maxRating = $maxRating;
        $this->readOnly = $readOnly;
        $this->hoverRating = null; // Default hover rating adalah null
        $this->$styleClass = $styleClass;
    }

    // Fungsi untuk mengubah rating saat pengguna klik
    public function setRating($rating)
    {
        if (!$this->readOnly) {
            $this->rating = $rating;
            $this->dispatch('ratingUpdated', $rating); // Emit event jika rating berubah
        }
    }

    public function render()
    {
        return view('livewire.components.star-rating');
    }
}
