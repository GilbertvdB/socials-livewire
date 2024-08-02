<?php

use App\Models\Post;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;

    public string $counter = "0";

    public function mount(): void
    {
        $this->counter = $this->post->like_count;
    }

}; ?>

<div>
    <p>Likes {{ $counter }}</p>
</div>
