<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'tags'])
            ->withCount(['answers', 'comments'])
            ->orderBy('created_at', 'desc');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        $posts = $query->paginate(10);
        $viewedPosts = auth()->check() ? auth()->user()->viewedPosts : collect();
        
        $popularTags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();
            
        $topUsers = User::orderBy('rating', 'desc')
            ->get();

        return view('home', compact('posts', 'viewedPosts', 'popularTags', 'topUsers'));
    }
} 