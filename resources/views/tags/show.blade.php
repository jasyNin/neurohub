@extends('layouts.app')

@section('title', '#' . $tag->name)

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="row">
        <!-- Боковое меню -->
        <x-side-menu />
        @include('components.side-menu-styles')

        <!-- Основной контент -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/tag.svg') }}" class="me-2" width="24" height="24" alt="Тег">
                        <h5 class="mb-0">#{{ $tag->name }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    @if($posts->isEmpty())
                        <div class="text-center py-5">
                            <img src="{{ asset('images/tag.svg') }}" class="mb-3" width="48" height="48" alt="Теги">
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
                                <div class="d-flex align-items-center text-muted">
                                    <span class="me-3">{{ $post->answers_count }} {{ __('answers.answers.' . min($post->answers_count, 20)) }}</span>
                                    <span>{{ $post->comments_count }} {{ __('comments.comments.' . min($post->comments_count, 20)) }}</span>
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