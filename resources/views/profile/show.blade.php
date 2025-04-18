@extends('layouts.app')

@section('title', 'Мой профиль')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="row">
        <!-- Боковое меню -->
        <x-side-menu />
        @include('components.side-menu-styles')

        <!-- Основной контент -->
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <x-user-avatar :user="$user" :size="150" class="mb-3" />
                    <h4 class="card-title">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    @if($user->bio)
                        <p class="card-text">{{ $user->bio }}</p>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать профиль</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Статистика</div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Посты
                        <span class="badge bg-primary rounded-pill">{{ $stats['posts_count'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Комментарии
                        <span class="badge bg-primary rounded-pill">{{ $stats['comments_count'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Получено лайков
                        <span class="badge bg-primary rounded-pill">{{ $stats['likes_received'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Закладки
                        <span class="badge bg-primary rounded-pill">{{ $stats['bookmarks_count'] }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#posts">Мои посты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#comments">Мои комментарии</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#bookmarks">Мои закладки</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="posts">
                            @if($posts->isEmpty())
                                <p class="text-center text-muted">У вас пока нет постов</p>
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
                                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                                <div>
                                                    <span class="badge bg-primary me-2">{{ $post->likes()->count() }} лайков</span>
                                                    <span class="badge bg-secondary">{{ $post->comments()->count() }} комментариев</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{ $posts->links() }}
                            @endif
                        </div>

                        <div class="tab-pane fade" id="comments">
                            @if($comments->isEmpty())
                                <p class="text-center text-muted">У вас пока нет комментариев</p>
                            @else
                                @foreach($comments as $comment)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p class="card-text">{{ $comment->content }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    К посту: <a href="{{ route('posts.show', $comment->post) }}" class="text-decoration-none">{{ $comment->post->title }}</a>
                                                    • {{ $comment->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{ $comments->links() }}
                            @endif
                        </div>

                        <div class="tab-pane fade" id="bookmarks">
                            @if($bookmarks->isEmpty())
                                <p class="text-center text-muted">У вас пока нет закладок</p>
                            @else
                                @foreach($bookmarks as $bookmark)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="{{ route('posts.show', $bookmark->post) }}" class="text-decoration-none">
                                                    {{ $bookmark->post->title }}
                                                </a>
                                            </h5>
                                            <p class="card-text">{{ Str::limit($bookmark->post->content, 200) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    Автор: <a href="{{ route('users.show', $bookmark->post->user) }}" class="text-decoration-none">{{ $bookmark->post->user->name }}</a>
                                                    • {{ $bookmark->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{ $bookmarks->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 