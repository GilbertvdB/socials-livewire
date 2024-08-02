<?php

use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
 
new class extends Component
{   
    public ?Post $post;

    #[Validate('required|string|max:255')]
    public string $message = ''; 
    
    public function store(): void
    {
        $validated = $this->validate();
        $validated['post_id'] = $this->post->id;
 
        $comment = auth()->user()->comments()->create($validated);
        $comment->post->increment('comment_count');
        
        $this->dispatch('update-comment-count');
 
        $this->message = '';

        $this->dispatch('comment-created');
        $this->dispatch('toggle-show.'.$this->post->id);
    } 
}; ?>
 
<div class="mt-4">
    <form wire:submit="store"> 
        <textarea
            wire:model="message"
            placeholder="{{ __('What\'s on your mind?') }}"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>
 
        <x-input-error :messages="$errors->get('message')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Comment') }}</x-primary-button>
    </form> 
</div>