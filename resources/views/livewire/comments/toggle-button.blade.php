<?php

use App\Models\Post;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {

    public ?Post $post;

    public string $action = 'Show';

    public bool $visible = false;
    
    public function mount(Post $post): void
    {   
        $this->post = $post;
        $this->showActionButton();
    }

    public function toggle(): void
    {
        if($this->action == "Show")
        {
            $this->toggleShow();
        } else {
            $this->toggleHide();
        }
    }

    
    #[On('toggle-show.{post.id}')]
    public function toggleShow()
    {   
        $this->action = "Hide";
        $this->dispatch('show-comments.'.$this->post->id);
    }

    
    #[On('toggle-hide')]
    public function toggleHide()
    {
        $this->action = "Show";
        $this->dispatch('hide-comments.'.$this->post->id);
    }

    #[On('update-comment-count')]
    public function showActionButton()
    {   
        if($this->post->comment_count > 0)
        {
            $this->visible = true;
        } else {
            $this->visible = false;
        }
    }

}; ?>

<div class="mb-4" wire:key="{{ $post->id }}">
    @if ($visible)
    <x-primary-button wire:click="toggle()">{{ $action }}</x-primary-button>
    @endif
</div>
