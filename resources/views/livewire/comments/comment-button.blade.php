<?php

use App\Models\Post;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Post $post;

    public string $counter = "0";

    public function mount(): void
    {
        
        $this->getCounter();
    }

    #[on('update-comment-count')]
    public function getCounter()
    {
        $this->counter = $this->post->comment_count;
    }
}; ?>

<div>
    <p>Comments {{ $counter }}</p>
</div>
