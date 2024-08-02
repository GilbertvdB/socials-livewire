<?php
 
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
 
new class extends Component
{   
    public ?Post $post;

    public Collection $comments;

    public ?Comment $editing = null;

    public bool $show = false;
 
    public function mount(Post $post): void
    {   
        $this->post = $post;
        $this->getComments();
    } 

    #[On('comment-created')]
    #[On('show-comments.{post.id}')]
    #[On('hide-comments.{post.id}')]
    public function getComments(): void
    {   
        $this->comments = Comment::where('post_id', $this->post->id)
            ->with('user')
            ->get();
    }

    public function edit(Comment $comment): void
    {
        $this->editing = $comment;
 
        $this->getComments();
    }

    #[On('comment-edit-canceled')]
    #[On('comment-updated')] 
    public function disableEditing(): void
    {
        $this->editing = null;
 
        $this->getComments();
    } 

    public function delete(Comment $comment): void
    {
        $this->authorize('delete', $comment);
        
        $comment->post->decrement('comment_count');
        $comment->delete();
 
        $this->getComments();

        $this->dispatch('update-comment-count');
    }

    #[On('show-comments.{post.id}')]
    public function showComments()
    {   
        $this->show = true;
        $this->getComments();
    }

    #[On('hide-comments.{post.id}')]
    public function hideComments()
    {   
        $this->show = false;
    }

}; ?>

<div class="mt-2 bg-white shadow-sm rounded-lg divide-y"> 
    @if($show)
    @foreach ($comments as $comment)
        <div class="py-6 flex space-x-2" wire:key="{{ $comment->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-800">{{ $comment->user->name }}</span>
                        <small class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('j M Y, g:i a') }}</small>
                        @unless ($comment->created_at->eq($comment->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                        @endunless
                    </div>
                    @if ($comment->user->is(auth()->user()))
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link wire:click="edit({{ $comment->id }})">
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="delete({{ $comment->id }})" wire:confirm="Are you sure to delete this comment?"> 
                                    {{ __('Delete') }}
                                </x-dropdown-link> 
                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
                @if ($comment->is($editing)) 
                    <livewire:comments.edit :comment="$comment" :key="$comment->id" />
                @else
                    <p class="text-lg text-gray-900">{{ $comment->message }}</p>
                @endif 
            </div>
        </div>
    @endforeach 
    @endif
</div>
