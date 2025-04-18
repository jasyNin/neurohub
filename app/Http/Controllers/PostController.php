<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Like;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Post::with(['user', 'tags']);

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $posts = $query->latest()->paginate(10);

        $popularTags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(10)
            ->get();

        $topUsers = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('posts', 'popularTags', 'topUsers'));
    }

    public function create()
    {
        // Получаем популярные теги
        $popularTags = Tag::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(10)
            ->get();
            
        // Получаем топ пользователей
        $topUsers = User::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        return view('posts.create', compact('popularTags', 'topUsers'));
    }

    public function store(Request $request)
    {
        // Отладочная информация
        \Log::info('Request data:', $request->all());
        \Log::info('Tags type:', ['type' => gettype($request->tags)]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:post,question',
            'tags' => 'nullable|string'
        ]);

        // Отладочная информация после валидации
        \Log::info('Validated data:', $validated);
        \Log::info('Validated tags type:', ['type' => gettype($validated['tags'])]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type']
        ]);

        // Обработка тегов
        if (!empty($validated['tags'])) {
            $tagNames = array_map('trim', explode(',', $validated['tags']));
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => Str::slug($tagName)]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            
            if (!empty($tagIds)) {
                $post->tags()->attach($tagIds);
            }
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Пост успешно создан.');
    }

    public function show(Post $post)
    {
        // Отмечаем просмотр
        if (auth()->check()) {
            $post->markAsViewed(auth()->user());
        }

        $post->increment('views_count');
        
        // Получаем популярные теги
        $popularTags = Tag::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(10)
            ->get();
            
        // Получаем топ пользователей
        $topUsers = User::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        $post->load(['user', 'tags', 'comments.user']);
        $similarPosts = Post::whereHas('tags', function ($query) use ($post) {
            $query->whereIn('tags.id', $post->tags->pluck('id'));
        })
        ->where('posts.id', '!=', $post->id)
        ->take(3)
        ->get();

        return view('posts.show', compact('post', 'similarPosts', 'popularTags', 'topUsers'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:post,question',
            'tags' => 'nullable|string'
        ]);

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type']
        ]);

        $post->tags()->detach();
        
        if (!empty($validated['tags'])) {
            $tagNames = array_map('trim', explode(',', $validated['tags']));
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => Str::slug($tagName)]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            
            if (!empty($tagIds)) {
                $post->tags()->attach($tagIds);
            }
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Пост успешно обновлен.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();
        
        return redirect()->route('home')
            ->with('success', 'Пост успешно удален!');
    }

    public function bookmark(Post $post)
    {
        $user = Auth::user();
        
        if ($post->isBookmarkedBy($user)) {
            Bookmark::where('user_id', $user->id)
                ->where('post_id', $post->id)
                ->delete();
            $message = 'Пост удален из закладок';
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $message = 'Пост добавлен в закладки';
        }
        
        return back()->with('success', $message);
    }

    public function rate(Request $request, Post $post)
    {
        $user = Auth::user();
        $value = $request->input('value');
        
        if ($post->hasUserRated($user)) {
            $post->ratings()->where('user_id', $user->id)->update(['value' => $value]);
        } else {
            $post->ratings()->create([
                'user_id' => $user->id,
                'value' => $value
            ]);
        }
        
        return back();
    }

    public function like(Post $post)
    {
        $user = auth()->user();
        
        if ($user->likes()->where('post_id', $post->id)->exists()) {
            $user->likes()->where('post_id', $post->id)->delete();
            $post->decrement('rating');
            $message = 'Лайк убран';
        } else {
            $user->likes()->create([
                'post_id' => $post->id
            ]);
            $post->increment('rating');
            $message = 'Лайк добавлен';
        }

        if (request()->ajax()) {
            return response()->json([
                'rating' => $post->rating,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
} 