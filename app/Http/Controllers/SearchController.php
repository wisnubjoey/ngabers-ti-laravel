<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->get('query');
            
            \Log::info('Search query:', ['query' => $query]); // Debug log

            $posts = Post::where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%")
                        ->with('user')
                        ->limit(5)
                        ->get();

            $users = User::where('name', 'like', "%{$query}%")
                        ->limit(5)
                        ->get();

            \Log::info('Search results:', [
                'posts_count' => $posts->count(),
                'users_count' => $users->count()
            ]); // Debug log

            return response()->json([
                'posts' => $posts,
                'users' => $users
            ]);

        } catch (\Exception $e) {
            \Log::error('Search error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}