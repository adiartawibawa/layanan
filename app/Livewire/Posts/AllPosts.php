<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class AllPosts extends Component
{
    use WithPagination;

    public $viewMode = 'list'; // Default view mode (list or card)
    public $showDetails = [
        'publish_date' => true,
        'author' => true,
        'read_time' => true,
    ]; // Toggle post details
    public $postsPerPage = 6; // Default number of posts to show per page
    public $infiniteScroll = false; // Infinite scroll feature toggle

    // Load more posts when using infinite scroll
    public function loadMore()
    {
        $this->postsPerPage += 6; // Increment posts by 6 or as needed
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        // Fetch posts with pagination
        $posts = Post::published()->latest()->paginate($this->postsPerPage);

        return view('livewire.posts.all-posts', compact('posts'));
    }
}
