<!-- resources/views/events/index.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header & Create Button -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Events Riding</h1>
                <a href="{{ route('events.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition">
                    + Buat Event
                </a>
            </div>
 
            <!-- Upcoming Events -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Event Mendatang</h2>
                
                @if($upcomingEvents->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($upcomingEvents as $event)
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                                <div class="p-5">
                                    <!-- Event Header -->
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-800">
                                                {{ $event->title }}
                                            </h3>
                                            <p class="text-gray-500 text-sm">
                                                oleh {{ $event->user->name }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                            Upcoming
                                        </span>
                                    </div>
 
                                    <!-- Event Info -->
                                    <div class="space-y-3 mb-4">
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $event->event_date->format('d M Y, H:i') }}
                                        </div>

                                        <div class="flex items-center text-gray-600 mt-2">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm">
                                                Selesai: {{ $event->estimated_end_date ? $event->estimated_end_date->format('d M Y, H:i') : 'Belum ditentukan' }}
                                            </span>
                                        </div>

                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $event->meeting_point }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                            </svg>
                                            {{ $event->destination }}
                                        </div>
                                    </div>
 
                                    <!-- Participants -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex -space-x-2">
                                            @foreach($event->participants->take(4) as $participant)
                                                <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden">
                                                    @if($participant->avatar)
                                                        <img src="{{ $participant->avatar }}" 
                                                             alt="{{ $participant->name }}"
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-600">
                                                            {{ substr($participant->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if($event->participants->count() > 4)
                                                <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-xs text-gray-600">
                                                    +{{ $event->participants->count() - 4 }}
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            {{ $event->participants->count() }} 
                                            {{ $event->max_participants ? '/ ' . $event->max_participants : '' }} 
                                            peserta
                                        </span>
                                    </div>
 
                                    <!-- Action Button -->
                                    <a href="{{ route('events.show', $event) }}" 
                                       class="block w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium px-4 py-2 rounded-lg transition">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Belum ada event mendatang.</p>
                @endif
            </div>
 
            <!-- Past Events -->
            <!-- Past Events -->
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Event Selesai</h2>
    
    @if($pastEvents->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pastEvents as $event)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 opacity-75">
                    <div class="p-5">
                        <!-- Event Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-gray-500 text-sm">
                                    oleh {{ $event->user->name }}
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                Selesai
                            </span>
                        </div>
 
                        <!-- Event Info -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $event->event_date->format('d M Y, H:i') }}
                            </div>
 
                            @if($event->estimated_end_date)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Selesai: {{ $event->estimated_end_date->format('d M Y, H:i') }}
                            </div>
                            @endif
 
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->meeting_point }}
                            </div>
 
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                {{ $event->destination }}
                            </div>
                        </div>
 
                        <!-- Participants -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex -space-x-2">
                                @foreach($event->participants->take(4) as $participant)
                                    <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden">
                                        @if($participant->avatar)
                                            <img src="{{ $participant->avatar }}" 
                                                 alt="{{ $participant->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-600">
                                                {{ substr($participant->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @if($event->participants->count() > 4)
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-xs text-gray-600">
                                        +{{ $event->participants->count() - 4 }}
                                    </div>
                                @endif
                            </div>
                            <span class="text-sm text-gray-500">
                                {{ $event->participants->count() }} 
                                {{ $event->max_participants ? '/ ' . $event->max_participants : '' }} 
                                peserta
                            </span>
                        </div>
 
                        <!-- Action Button -->
                        <a href="{{ route('events.show', $event) }}" 
                           class="block w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium px-4 py-2 rounded-lg transition">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Belum ada event selesai.</p>
    @endif
 </div>
        </div>
    </div>
 </x-app-layout>