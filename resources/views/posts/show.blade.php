<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <!-- Detail Post -->
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                    
                    <!-- Media -->
                    @if($post->media_path)
                        @if(str_contains($post->media_type, 'image'))
                            <img src="{{ $post->media_path }}" 
                                 class="max-w-full rounded mb-4">
                        @else
                            <video controls class="w-full mb-4">
                                <source src="{{ $post->media_path }}" 
                                        type="{{ $post->media_type }}">
                            </video>
                        @endif
                    @endif

                    <p class="mb-4">{{ $post->content }}</p>

                    <!-- Like Button -->
                    <form action="{{ route('posts.like', $post) }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-blue-500">
                            {{ $isLiked ? '❤️' : '🤍' }}
                            {{ $post->likes->count() }} Likes
                        </button>
                    </form>

                    <!-- Comment Form -->
                    <!-- Comments Section di show.blade.php -->
<div class="mt-8">
    <!-- Comment Form -->
    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
        @csrf
        <div class="flex space-x-4">
            <!-- User Avatar -->
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full">
            @else
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            
            <div class="flex-1">
                <textarea name="content" 
                          rows="3" 
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                          placeholder="Tulis komentar..."></textarea>
                <button type="submit" 
                        class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                    Kirim Komentar
                </button>
            </div>
        </div>
    </form>

    <!-- Comments List -->
    <div class="space-y-6">
        @foreach($post->comments->whereNull('parent_id') as $comment)
            <div class="flex space-x-4">
                <!-- Commenter Avatar -->
                @if($comment->user->avatar)
                    <img src="{{ $comment->user->avatar }}" 
                         class="w-10 h-10 rounded-full">
                @else
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                        {{ substr($comment->user->name, 0, 1) }}
                    </div>
                @endif

                <div class="flex-1">
                    <!-- Main Comment -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <a href="{{ route('profile.show', $comment->user) }}" 
                                   class="font-medium text-gray-900 hover:underline">
                                    {{ $comment->user->name }}
                                </a>
                                <p class="text-sm text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            @if(auth()->id() === $comment->user_id)
                                <form action="{{ route('comments.destroy', $comment) }}" 
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-600 text-sm"
                                            onclick="return confirm('Hapus komentar ini?')">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>

                        <p class="mt-2 text-gray-700">{{ $comment->content }}</p>

                        <!-- Reply Button -->
                        <button onclick="toggleReplyForm('{{ $comment->id }}')"
                                class="mt-2 text-sm text-gray-500 hover:text-gray-700">
                            Balas
                        </button>

                        <!-- Reply Form (Hidden by default) -->
                        <div id="replyForm{{ $comment->id }}" class="hidden mt-4">
                            <form action="{{ route('comments.store', $post) }}" method="POST">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="content" 
                                          rows="2"
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 text-sm"
                                          placeholder="Tulis balasan..."></textarea>
                                <button type="submit" 
                                        class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">
                                    Kirim Balasan
                                </button>
                            </form>
                        </div>

                        <!-- Replies -->
                        @if($comment->replies->count() > 0)
                            <div class="mt-4 space-y-4 ml-6 border-l-2 border-gray-100 pl-4">
                                @foreach($comment->replies as $reply)
                                    <div class="flex space-x-4">
                                        <!-- Replier Avatar -->
                                        @if($reply->user->avatar)
                                            <img src="{{ $reply->user->avatar }}" 
                                                 class="w-8 h-8 rounded-full">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm">
                                                {{ substr($reply->user->name, 0, 1) }}
                                            </div>
                                        @endif

                                        <div class="flex-1 bg-white rounded-lg p-3">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <a href="{{ route('profile.show', $reply->user) }}" 
                                                       class="font-medium text-gray-900 hover:underline">
                                                        {{ $reply->user->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $reply->created_at->diffForHumans() }}
                                                    </p>
                                                </div>

                                                @if(auth()->id() === $reply->user_id)
                                                    <form action="{{ route('comments.destroy', $reply) }}" 
                                                          method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-500 hover:text-red-600 text-xs"
                                                                onclick="return confirm('Hapus balasan ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-gray-700 text-sm">
                                                {{ $reply->content }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById(`replyForm${commentId}`);
    form.classList.toggle('hidden');
}
</script>

                    <!-- Post Actions -->
                    @if(auth()->id() === $post->user_id)
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('posts.edit', $post) }}" 
                               class="bg-blue-500 text-white px-4 py-2 rounded">
                                Edit Post
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 text-white px-4 py-2 rounded"
                                        onclick="return confirm('Hapus post?')">
                                    Hapus Post
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk toggle form reply -->
    <script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('replyForm' + commentId);
        form.classList.toggle('hidden');
    }
    </script>
</x-app-layout>