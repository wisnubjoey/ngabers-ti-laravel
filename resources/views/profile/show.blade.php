<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="p-6">
                    <!-- Header Profile -->
                    <div class="flex items-center">
                        <!-- Avatar -->
                        <div class="mr-4">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-24 h-24 rounded-full object-cover">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-2xl">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Info Dasar -->
                        <div>
                            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                            @if($user->bio)
                                <p class="text-gray-600">{{ $user->bio }}</p>
                            @endif
                            
                            @if($user->instagram)
                                <a href="https://instagram.com/{{ $user->instagram }}" 
                                   target="_blank"
                                   class="text-pink-600 hover:underline">
                                    📸 {{ $user->instagram }}
                                </a>
                            @endif
                        </div>

                        <!-- Edit Button -->
                        @if(auth()->id() === $user->id)
                            <div class="ml-auto">
                                <a href="{{ route('profile.edit') }}" 
                                   class="bg-blue-500 text-white px-4 py-2 rounded">
                                    Edit Profile
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Info Motor -->
                    @if($user->motor_merk || $user->motor_type)
                        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                            <h2 class="font-bold text-lg mb-2">Info Motor</h2>
                            <div class="grid grid-cols-2 gap-4">
                                @if($user->motor_merk)
                                    <div>
                                        <span class="font-medium">Merk:</span>
                                        <span>{{ $user->motor_merk }}</span>
                                    </div>
                                @endif
                                @if($user->motor_type)
                                    <div>
                                        <span class="font-medium">Tipe:</span>
                                        <span>{{ $user->motor_type }}</span>
                                    </div>
                                @endif
                                @if($user->motor_year)
                                    <div>
                                        <span class="font-medium">Tahun:</span>
                                        <span>{{ $user->motor_year }}</span>
                                    </div>
                                @endif
                                @if($user->motor_odo)
                                    <div>
                                        <span class="font-medium">ODO:</span>
                                        <span>{{ $user->motor_odo }} KM</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Posts -->
                    <div class="mt-6">
                        <h2 class="font-bold text-lg mb-4">Posts</h2>
                        @if($posts->count() > 0)
                            <div class="space-y-4">
                                @foreach($posts as $post)
                                    <div class="border rounded-lg p-4">
                                        <h3 class="font-bold">{{ $post->title }}</h3>
                                        <p class="text-gray-600">{{ $post->content }}</p>
                                        <div class="mt-2 text-sm text-gray-500">
                                            {{ $post->created_at->diffForHumans() }} •
                                            {{ $post->likes->count() }} likes •
                                            {{ $post->comments->count() }} comments
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada post.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>