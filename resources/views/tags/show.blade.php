@extends('layouts.app')

@section('title', '#' . $tag->name)

@section('content')
<div class="container">
    <div class="row">
        <!-- Боковое меню -->
        <x-side-menu />
        @include('components.side-menu-styles')

        <!-- Основной контент -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9.5 3L4 8.5V15.5L9.5 21L16.5 15.5L22 10L16.5 4.5L9.5 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h5 class="mb-0">#{{ $tag->name }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    @if($posts->isEmpty())
                        <div class="text-center py-5">
                            <svg class="mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                <path d="M9.5 3L4 8.5V15.5L9.5 21L16.5 15.5L22 10L16.5 4.5L9.5 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h5>Пока нет постов</h5>
                            <p class="text-muted">Будьте первым, кто создаст пост с этим тегом</p>
                        </div>
                    @else
                        @foreach($posts as $post)
                            <div class="post-item mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <x-user-avatar :user="$post->user" :size="32" class="me-2" />
                                    <div>
                                        <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none">{{ $post->user->name }}</a>
                                        <small class="text-muted d-block">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <h5 class="mb-2">
                                    <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a>
                                </h5>
                                <p class="text-muted mb-2">{{ Str::limit($post->content, 200) }}</p>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <svg class="me-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 4L12 20M4 12L20 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                        {{ $post->answers_count }} {{ __('posts.answers.' . min($post->answers_count, 20)) }}
                                    </div>
                                    <div class="me-3">
                                        <svg class="me-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M21 11.5C21 12.8807 19.8807 14 18.5 14C17.1193 14 16 12.8807 16 11.5C16 10.1193 17.1193 9 18.5 9C19.8807 9 21 10.1193 21 11.5Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M8 11.5C8 12.8807 6.88071 14 5.5 14C4.11929 14 3 12.8807 3 11.5C3 10.1193 4.11929 9 5.5 9C6.88071 9 8 10.1193 8 11.5Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M12 11.5C12 12.8807 10.8807 14 9.5 14C8.11929 14 7 12.8807 7 11.5C7 10.1193 8.11929 9 9.5 9C10.8807 9 12 10.1193 12 11.5Z" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                        {{ $post->comments_count }} {{ __('posts.comments.' . min($post->comments_count, 20)) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Правая колонка -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">Популярные теги</div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($tag->posts->pluck('tags')->flatten()->unique('id')->take(10) as $relatedTag)
                            @if($relatedTag->id !== $tag->id)
                                <a href="{{ route('tags.show', $relatedTag) }}" class="badge bg-secondary text-decoration-none">
                                    #{{ $relatedTag->name }}
                                    <span class="ms-1">{{ $relatedTag->posts_count }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Топ пользователей</div>
                <div class="list-group list-group-flush">
                    @foreach($tag->posts->pluck('user')->unique('id')->take(5) as $user)
                        <a href="{{ route('users.show', $user) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <x-user-avatar :user="$user" :size="32" class="me-3" />
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->posts_count }} {{ __('posts.posts.' . min($user->posts_count, 20)) }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 