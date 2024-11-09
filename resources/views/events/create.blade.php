<!-- resources/views/events/create.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Event Baru</h2>
 
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf
 
                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Event
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                                   value="{{ old('title') }}"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Event
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4" 
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <!-- Date & Time -->
                        <div class="mb-6">
                            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal & Waktu
                            </label>
                            <input type="datetime-local" 
                                   id="event_date" 
                                   name="event_date" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                                   value="{{ old('event_date') }}"
                                   required>
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="estimated_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Perkiraan Event Selesai
                            </label>
                            <input type="datetime-local" 
                                   id="estimated_end_date" 
                                   name="estimated_end_date" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                                   value="{{ old('estimated_end_date') }}"
                                   required>
                            @error('estimated_end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <!-- Meeting Point -->
                        <div class="mb-6">
                            <label for="meeting_point" class="block text-sm font-medium text-gray-700 mb-2">
                                Meeting Point
                            </label>
                            <input type="text" 
                                   id="meeting_point" 
                                   name="meeting_point" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                                   value="{{ old('meeting_point') }}"
                                   required>
                            @error('meeting_point')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <!-- Destination -->
                        <div class="mb-6">
                            <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                                Tujuan
                            </label>
                            <input type="text" 
                                   id="destination" 
                                   name="destination" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                                   value="{{ old('destination') }}"
                                   required>
                            @error('destination')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <!-- Max Participants -->
                        <div class="mb-8">
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">
                                Maksimal Peserta (Opsional)
                            </label>
                            <input type="number" 
                                   id="max_participants" 
                                   name="max_participants" 
                                   min="2"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
                                   value="{{ old('max_participants') }}">
                            <p class="mt-1 text-sm text-gray-500">
                                Kosongkan jika tidak ada batasan peserta
                            </p>
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg transition duration-150">
                                Buat Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </x-app-layout>