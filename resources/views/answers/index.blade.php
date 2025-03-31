@extends('layouts.app')

@section('title', 'Ответы')

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
                    <h5 class="mb-0">Ответы</h5>
                </div>
                <div class="card-body">
                    @if($answers->isEmpty())
                        <div class="text-center py-5">
                            <svg class="mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h5>Пока нет ответов</h5>
                            <p class="text-muted">Будьте первым, кто ответит на вопрос</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($answers as $answer)
                                <div class="list-group-item">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            <x-user-avatar :user="$answer->user" :size="40" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <a href="{{ route('users.show', $answer->user) }}" class="text-decoration-none text-dark fw-bold">{{ $answer->user->name }}</a>
                                                    <small class="text-muted ms-2">{{ $answer->created_at->diffForHumans() }}</small>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-primary me-2">{{ $answer->rating }}</span>
                                                    <span class="text-muted">{{ $answer->comments_count }} {{ __('comments.comments.' . min($answer->comments_count, 20)) }}</span>
                                                </div>
                                            </div>
                                            <div class="mb-2">{{ $answer->content }}</div>
                                            <div class="text-muted">
                                                <small>Ответ на вопрос: <a href="{{ route('posts.show', $answer->post) }}" class="text-decoration-none">{{ $answer->post->title }}</a></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $answers->links() }}
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