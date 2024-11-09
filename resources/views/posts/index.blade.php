<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Create Post Button -->
            <div class="mb-6">
                <a href="{{ route('posts.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Post Baru
                </a>
            </div>
 
            <!-- Posts List -->
            @foreach($posts as $post)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 mb-6 overflow-hidden">
                    <!-- Post Header -->
                    <div class="p-4 border-b">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    @if($post->user->avatar)
                                        <img src="{{ $post->user->avatar }}" 
                                             alt="{{ $post->user->name }}"
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-lg font-medium text-gray-600">
                                                {{ substr($post->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
 
                                <!-- User Info -->
                                <div>
                                    <a href="{{ route('profile.show', $post->user) }}" 
                                       class="font-medium text-gray-900 hover:underline">
                                        {{ $post->user->name }}
                                    </a>
                                    <p class="text-sm text-gray-500">
                                        {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
 
                            <!-- Post Actions Dropdown -->
                            @if(auth()->id() === $post->user_id)
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                        <a href="{{ route('posts.edit', $post) }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Edit Post
                                        </a>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus post ini?')">
                                                Hapus Post
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
 
                    <!-- Post Content -->
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h2>
                        <p class="text-gray-700 mb-4">{{ $post->content }}</p>
 
                        <!-- Media -->
                        @if($post->media_path)
                            <div class="rounded-lg overflow-hidden mb-4">
                                @if(str_contains($post->media_type, 'image'))
                                    <img src="{{ $post->media_path }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-auto">
                                @else
                                    <video controls class="w-full">
                                        <source src="{{ $post->media_path }}" 
                                                type="{{ $post->media_type }}">
                                    </video>
                                @endif
                            </div>
                        @endif
 
                        <!-- Post Actions -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <div class="flex items-center space-x-6">
                                <!-- Like Button -->
                                <form class="like-form" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <button type="submit" 
                                            class="like-button group flex items-center space-x-2 text-gray-500 hover:text-red-500 transition-colors duration-150" 
                                            id="like-button-{{ $post->id }}">
                                        <span class="transform group-hover:scale-125 transition-transform duration-150">
                                            {{ $post->isLikedBy(auth()->user()) ? '❤️' : '🤍' }}
                                        </span>
                                        <span class="like-count text-sm" id="like-count-{{ $post->id }}">
                                            {{ $post->likes->count() }}
                                        </span>
                                    </button>
                                </form>
 
                                <!-- Comment Button -->
                                <a href="{{ route('posts.show', $post) }}" 
                                   class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition-colors duration-150">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span class="text-sm">{{ $post->comments->count() }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
 
    <!-- Alpine.js for dropdowns -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
 
    <!-- AJAX for likes -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeForms = document.querySelectorAll('.like-form');
        
        likeForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const postId = this.dataset.postId;
                const button = document.querySelector(`#like-button-${postId}`);
                const counter = document.querySelector(`#like-count-${postId}`);
                
                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update like button with animation
                    const span = button.querySelector('span:first-child');
                    span.style.transform = 'scale(1.3)';
                    setTimeout(() => span.style.transform = 'scale(1)', 150);
                    
                    span.innerHTML = data.isLiked ? '❤️' : '🤍';
                    counter.textContent = data.likesCount;
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
    </script>
 </x-app-layout>