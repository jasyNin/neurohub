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
            ->latest();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        $posts = $query->paginate(10);

        $popularTags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        $topUsers = User::withCount(['posts', 'comments', 'answers'])
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('posts', 'popularTags', 'topUsers'));
    }
} 