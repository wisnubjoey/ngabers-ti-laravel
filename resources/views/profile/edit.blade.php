<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Edit Profile</h2>

                    <form action="{{ route('profile.update') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Foto Profile
                            </label>
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" 
                                     class="w-24 h-24 rounded-full object-cover mb-2">
                            @endif
                            <input type="file" name="avatar" accept="image/*" class="w-full">
                        </div>

                        <!-- Info Dasar -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Bio
                            </label>
                            <textarea name="bio" 
                                      rows="3"
                                      class="w-full border rounded px-3 py-2">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Info Motor -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Merk Motor
                            </label>
                            <input type="text" 
                                   name="motor_merk"
                                   value="{{ old('motor_merk', $user->motor_merk) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tipe Motor
                            </label>
                            <input type="text" 
                                   name="motor_type"
                                   value="{{ old('motor_type', $user->motor_type) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tahun Motor
                            </label>
                            <input type="text" 
                                   name="motor_year"
                                   value="{{ old('motor_year', $user->motor_year) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                ODO (KM)
                            </label>
                            <input type="text" 
                                   name="motor_odo"
                                   value="{{ old('motor_odo', $user->motor_odo) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <!-- Social Media -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Instagram (username saja)
                            </label>
                            <input type="text" 
                                   name="instagram"
                                   value="{{ old('instagram', $user->instagram) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>