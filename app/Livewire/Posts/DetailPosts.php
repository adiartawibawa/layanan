<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DetailPosts extends Component
{
    public ?Post $slug;
    public $post;

    public function mount()
    {
        $this->post = $this->slug;
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.posts.detail-posts');
    }
}
