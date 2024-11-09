<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PostController extends Controller
{
    public function index()
    {
        // Ambil semua post, urutkan dari terbaru
        $posts = Post::with(['user', 'likes', 'comments'])
                    ->latest()
                    ->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov|max:51200'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = auth()->id();

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            
            $isVideo = str_contains($file->getMimeType(), 'video');

            $uploadOptions = [
                'folder' => 'posts',
                'resource_type' => 'auto',
            ];

            if ($isVideo) {
                $uploadOptions['transformation'] = [
                    'width' => 1920,
                    'height' => 1080,
                    'crop' => 'limit',
                    'bit_rate' => '700k',
                    'quality' => 'auto:good',
                    'video_codec' => 'h264'
                ];
            }

            $uploadedFile = Cloudinary::upload($file->getRealPath(), $uploadOptions);

            // ini type media nya
            $post->media_type = $file->getMimeType();
            // Ini yang perlu diubah
            $post->media_path = $uploadedFile->getSecurePath(); // URL untuk menampilkan media
            $post->media_public_id = $uploadedFile->getPublicId(); // ID untuk keperluan delete
        }

        $post->save();

        return redirect()->route('posts.index')
                        ->with('success', 'Post berhasil dibuat!');
    }

    public function show(Post $post)
    {
        $post->load(['comments.user', 'likes']);
        $isLiked = $post->isLikedBy(auth()->user());

        return view('posts.show', compact('post', 'isLiked'));
    }

    public function toggleLike(Post $post)
{
    $isLiked = !$post->isLikedBy(auth()->user());
    if ($isLiked) {
        $post->likes()->attach(auth()->id());
    } else {
        $post->likes()->detach(auth()->id());
    }
    
    return response()->json([
        'isLiked' => $isLiked,
        'likesCount' => $post->likes()->count()
    ]);
}

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            return back()->with('error', 'Anda tidak diperbolehkan menghapus post ini.');
        }
    
        if ($post->media_public_id) {
            Cloudinary::destroy($post->media_public_id);
        }
    
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus!');
    }

    public function edit(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            return back()->with('error', 'Anda tidak diperbolehkan mengedit post ini.');
        }
        
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            return back()->with('error', 'Anda tidak diperbolehkan mengedit post ini.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov|max:51200'
        ]);

        try {
            $post->title = $request->title;
            $post->content = $request->content;

            if ($request->hasFile('media')) {
                $file = $request->file('media');
                
                if ($post->media_public_id) {
                    Cloudinary::destroy($post->media_public_id);
                }

                $isVideo = str_contains($file->getMimeType(), 'video');
                $uploadOptions = [
                    'folder' => 'posts',
                    'resource_type' => 'auto',
                ];

                if ($isVideo) {
                    $uploadOptions['transformation'] = [
                        'width' => 1920,
                        'height' => 1080,
                        'crop' => 'limit',
                        'bit_rate' => '700k',
                        'quality' => 'auto:good',
                        'video_codec' => 'h264'
                    ];
                }

                $uploadedFile = Cloudinary::upload($file->getRealPath(), $uploadOptions);

                $post->media_type = $file->getMimeType();
                $post->media_path = $uploadedFile->getSecurePath();
                $post->media_public_id = $uploadedFile->getPublicId();
            }

            $post->save();

            return redirect()->route('posts.index')->with('success', 'Post berhasil diupdate!');
        } catch (\Exception $e) {
            \Log::error('Update failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate post: ' . $e->getMessage());
        }
    }
}