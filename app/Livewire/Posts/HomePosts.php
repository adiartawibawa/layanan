<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class HomePosts extends Component
{
    public $posts;

    public function mount()
    {
        // Ambil 6 post terbaru yang telah dipublikasikan
        $this->posts = Post::published()->latest()->take(6)->get();
    }

    public function render()
    {
        return view('livewire.posts.home-posts', [
            'posts' => $this->posts,
        ]);
    }
}
