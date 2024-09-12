<?php

namespace App\Livewire\Posts;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AllPosts extends Component
{
    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.posts.all-posts');
    }
}
