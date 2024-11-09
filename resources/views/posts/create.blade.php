<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">Buat Post Baru</h2>

                    <form action="{{ route('posts.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Judul Post
                            </label>
                            <input type="text" 
                                   name="title" 
                                   class="w-full border rounded p-2" 
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Konten
                            </label>
                            <textarea name="content" 
                                      rows="4" 
                                      class="w-full border rounded p-2" 
                                      required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Media (Gambar/Video)
                            </label>
                            <input type="file" 
                                   name="media" 
                                   accept="image/*,video/*" 
                                   class="w-full border rounded p-2">
                            <p class="text-sm text-gray-500 mt-1">
                                Max size: 50MB. Format: jpg, jpeg, png, mp4
                            </p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded">
                                Posting
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>