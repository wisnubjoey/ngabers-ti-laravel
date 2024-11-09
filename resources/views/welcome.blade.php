<x-guest-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Selamat Datang di Ngabers
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Komunitas Motor SMK TI Bali Global Badung
                </p>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" 
                       class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-white text-green-600 border border-green-600 px-6 py-3 rounded-lg font-medium hover:bg-green-50 transition">
                        Register
                    </a>
                </div>
            </div>

            <!-- Preview Posts -->
            @foreach($posts as $post)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition mb-6 relative overflow-hidden">
                    <!-- Blur Overlay -->
                    <div class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 flex items-center justify-center">
                        <div class="text-center p-4">
                            <p class="text-gray-900 font-medium mb-4">
                                Mau lihat post lebih lanjut?
                            </p>
                            <a href="{{ route('login') }}" 
                               class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                                Login dulu
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Post Header -->
                        <div class="flex items-center mb-4">
                            <a href="{{ route('login') }}" class="flex items-center">
                                @if($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-lg font-medium text-gray-600">
                                            {{ substr($post->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">{{ $post->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </div>

                        <!-- Post Content -->
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h2>
                        <p class="text-gray-700 mb-4">{{ $post->content }}</p>

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
                                <a href="{{ route('login') }}" 
                                   class="flex items-center space-x-2 text-gray-500">
                                    <span>🤍</span>
                                    <span>{{ $post->likes->count() }}</span>
                                </a>
                                <a href="{{ route('login') }}" 
                                   class="flex items-center space-x-2 text-gray-500">
                                    <span>💬</span>
                                    <span>{{ $post->comments->count() }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Call to Action -->
            <div class="text-center mt-8">
                <p class="text-gray-600 mb-4">
                    Ingin melihat lebih banyak posts dan bergabung dengan komunitas?
                </p>
                <a href="{{ route('register') }}" 
                   class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition">
                    Gabung Sekarang
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>