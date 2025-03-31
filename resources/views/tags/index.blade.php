@extends('layouts.app')

@section('title', 'Теги')

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
                    <h5 class="mb-0">Теги</h5>
                </div>
                <div class="card-body">
                    @if($tags->isEmpty())
                        <div class="text-center py-5">
                            <svg class="mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                <path d="M9.5 3L4 8.5V15.5L9.5 21L16.5 15.5L22 10L16.5 4.5L9.5 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h5>Пока нет тегов</h5>
                            <p class="text-muted">Создайте первый пост, чтобы добавить теги</p>
                        </div>
                    @else
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none p-3">
                                    <div class="d-flex align-items-center">
                                        <svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M9.5 3L4 8.5V15.5L9.5 21L16.5 15.5L22 10L16.5 4.5L9.5 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div>
                                            <div class="fw-bold">#{{ $tag->name }}</div>
                                            <small class="text-white-50">{{ $tag->posts_count }} {{ __('posts.posts.' . min($tag->posts_count, 20)) }}</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $tags->links() }}
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
                        @foreach($popularTags as $tag)
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
                    @foreach($topUsers as $user)
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