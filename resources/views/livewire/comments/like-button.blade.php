<?php

use App\Models\Post;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;

    public string $action = "Like";

    public string $counter = "0";

    public function mount(): void
    {

        $this->getCounter();
    }

    public function getCounter()
    {
        $this->counter = $this->post->like_count;
    }
    public function toggle()
    {
        if($this->action == "Like")
        {
            $this->action = "Unlike";
            $this->post->increment('like_count');
            $this->getCounter();
        } else {
            $this->action = "Like";
            $this->post->decrement('like_count');
            $this->getCounter();
        }
    }

}; ?>

<div class="mb-4" wire:key="{{ $post->id }}">
    <button wire:click="toggle()">
        {{ $action }}
    </button>
    {{ $counter }}
</div>