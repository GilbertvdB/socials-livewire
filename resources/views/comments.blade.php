<x-app-layout>
    <div class="post flex flex-col space-y-4 mt-4 px-4 max-w-2xl mx-auto">
        @foreach($posts as $post)
        <div wire:key="{{$post->id}}" class="bg-white w-full p-4 sm:px-6 lg:px-8">
            <div class="title">
                <h1 class="text-bold text-xl">{{ $post->title}}</h1>
            </div>
            <div class="content mb-2">
                {{ $post->content}}
            </div>
            Post ID = {{ $post->id}}
            <hr/>
        
            <div class="flex space-x-4 py-2">
                <livewire:comments.like-button :$post />
                <livewire:comments.comment-button :$post />
            </div>
            
            <livewire:comments.toggle-button :$post />
            <livewire:comments.list :$post />

            <livewire:comments.create :$post />
        </div>
        @endforeach
    </div>
</x-app-layout>