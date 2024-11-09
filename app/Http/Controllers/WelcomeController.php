<?php

namespace App\Http\Controllers;

use App\Models\Post;

class WelcomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments'])
                    ->latest()
                    ->take(5)
                    ->get();
                    
        return view('welcome', compact('posts'));
    }
}
