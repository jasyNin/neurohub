@extends('layouts.app')

@section('title', 'Главная')

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
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ !request('type') ? 'active' : '' }}" href="{{ route('home') }}">Все</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request('type') === 'post' ? 'active' : '' }}" href="{{ route('home', ['type' => 'post']) }}">Записи</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request('type') === 'question' ? 'active' : '' }}" href="{{ route('home', ['type' => 'question']) }}">Вопросы</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    @if($posts->isEmpty())
                        <p class="text-center text-muted">Пока нет постов</p>
                    @else
                        @foreach($posts as $post)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-{{ $post->type === 'post' ? 'primary' : 'success' }} me-2">
                                                {{ $post->type === 'post' ? 'Запись' : 'Вопрос' }}
                                            </span>
                                            <small class="text-muted">
                                                Автор: <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none">{{ $post->user->name }}</a>
                                                • {{ $post->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">{{ $post->rating }}</span>
                                            <span class="text-muted">{{ $post->answers_count }} {{ __('answers.answers.' . min($post->answers_count, 20)) }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="tags">
                                            @foreach($post->tags as $tag)
                                                <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none me-1">
                                                    #{{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
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
            @auth
                @if($viewedPosts->isNotEmpty())
                    <div class="card mb-4">
                        <div class="card-header">Просмотренные посты</div>
                        <div class="list-group list-group-flush">
                            @foreach($viewedPosts as $post)
                                <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">{{ Str::limit($post->title, 40) }}</h6>
                                        <span class="badge bg-{{ $post->type === 'post' ? 'primary' : 'success' }}">
                                            {{ $post->type === 'post' ? 'Запись' : 'Вопрос' }}
                                        </span>
                                    </div>
                                    <small class="text-muted d-block">{{ $post->user->name }}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endauth

            <div class="card mb-4">
                <div class="card-header">Популярные теги</div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($popularTags->take(4) as $tag)
                            <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none">
                                #{{ $tag->name }}
                                <span class="ms-1">{{ $tag->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Топ пользователей</div>
                <div class="list-group list-group-flush">
                    @foreach($topUsers->take(3) as $user)
                        <a href="{{ route('users.show', $user) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <x-user-avatar :user="$user" :size="32" class="me-3" />
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->rating }} {{ __('rating.points') }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 