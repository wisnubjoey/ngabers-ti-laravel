<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <!-- Event Header -->
                <div class="p-6 border-b bg-gradient-to-r from-green-500 to-green-600 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold">{{ $event->title }}</h1>
                            <p class="mt-2">
                                Dibuat oleh 
                                <a href="{{ route('profile.show', $event->user) }}" 
                                   class="font-medium hover:underline">
                                    {{ $event->user->name }}
                                </a>
                            </p>
                        </div>
                        
                        <!-- Join Button -->
                        @if($event->status === 'upcoming')
                            <form action="{{ route('events.join', $event) }}" method="POST">
                                @csrf
                                @if($isJoined)
                                    <button type="submit" 
                                            class="bg-white text-green-600 px-6 py-2 rounded-lg font-medium hover:bg-green-50 transition">
                                        Batal Ikut
                                    </button>
                                @elseif($canJoin)
                                    <button type="submit" 
                                            class="bg-white text-green-600 px-6 py-2 rounded-lg font-medium hover:bg-green-50 transition">
                                        Ikut Event
                                    </button>
                                @else
                                    <button type="button" 
                                            class="bg-gray-300 text-gray-600 px-6 py-2 rounded-lg font-medium cursor-not-allowed"
                                            disabled>
                                        Event Penuh
                                    </button>
                                @endif
                            </form>
                        @endif
                    </div>
                </div>
 
                <div class="p-6">
                    <!-- Event Info Grid -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <!-- Event Details -->
                            <div class="space-y-4">
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Tanggal & Waktu</p>
                                        <p class="text-gray-600">{{ $event->event_date->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center text-gray-700">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Perkiraan Selesai</p>
                                        <p class="text-gray-600">{{ $event->estimated_end_date->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
 
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Meeting Point</p>
                                        <p class="text-gray-600">{{ $event->meeting_point }}</p>
                                    </div>
                                </div>
 
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Tujuan</p>
                                        <p class="text-gray-600">{{ $event->destination }}</p>
                                    </div>
                                </div>
 
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Kapasitas</p>
                                        <p class="text-gray-600">
                                            {{ $event->participants->count() }} 
                                            {{ $event->max_participants ? '/ ' . $event->max_participants : '' }} 
                                            peserta
                                        </p>
                                    </div>
                                </div>
                            </div>
 
                            <!-- Description -->
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>
                            </div>
                        </div>
 
                        <!-- Participants List -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Peserta</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-3">
                                    @foreach($event->participants as $participant)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                @if($participant->avatar)
                                                    <img src="{{ $participant->avatar }}" 
                                                         alt="{{ $participant->name }}"
                                                         class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                                        {{ substr($participant->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('profile.show', $participant) }}" 
                                                       class="font-medium text-gray-900 hover:underline">
                                                        {{ $participant->name }}
                                                    </a>
                                                    @if($participant->id === $event->user_id)
                                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                            Creator
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if(auth()->id() === $event->user_id && $event->status === 'upcoming')
    <form action="{{ route('events.complete', $event) }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" 
                onclick="return confirm('Tandai event ini sebagai selesai?')"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
            Tandai Selesai
        </button>
    </form>
@endif

<!-- atau jika sudah selesai -->
@if($event->status === 'completed')
    <div class="mt-4">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Event Selesai
        </span>
    </div>
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
 </x-app-layout>