<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->paginate(20);

        $popularTags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        $topUsers = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        return view('tags.index', compact('tags', 'popularTags', 'topUsers'));
    }

    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->with(['user', 'tags'])
            ->withCount(['answers', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Получаем похожие теги через join
        $similarTags = Tag::select('tags.*')
            ->join('post_tag as pt1', 'tags.id', '=', 'pt1.tag_id')
            ->join('post_tag as pt2', 'pt1.post_id', '=', 'pt2.post_id')
            ->where('pt2.tag_id', $tag->id)
            ->where('tags.id', '!=', $tag->id)
            ->withCount('posts')
            ->groupBy('tags.id')
            ->orderBy('posts_count', 'desc')
            ->limit(10)
            ->get();

        return view('tags.show', compact('tag', 'posts', 'similarTags'));
    }
} 