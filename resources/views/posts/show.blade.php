@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container">
    <div class="row">
        <!-- Боковое меню -->
        <x-side-menu />
        @include('components.side-menu-styles')

        <!-- Основной контент -->
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="h3 mb-2">{{ $post->title }}</h1>
                            <div class="d-flex align-items-center text-muted">
                                <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none me-3 d-flex align-items-center">
                                    <x-user-avatar :user="$post->user" :size="32" class="me-2" />
                                    {{ $post->user->name }}
                                </a>
                                <span class="me-3">{{ $post->created_at->diffForHumans() }}</span>
                                <span class="me-3">{{ $post->views_count }} {{ __('posts.views.' . min($post->views_count, 20)) }}</span>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @can('update', $post)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('posts.edit', $post) }}">
                                            Редактировать
                                        </a>
                                    </li>
                                @endcan
                                @can('delete', $post)
                                    <li>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Вы уверены?')">
                                                Удалить
                                            </button>
                                        </form>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>

                    <div class="post-content mb-4">
                        {!! $post->content !!}
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="me-3">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark p-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}">
                                        <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="ms-1">{{ $post->likes_count }}</span>
                                </button>
                            </form>

                            <form action="{{ route('posts.bookmark', $post) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark p-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $post->isBookmarkedBy(auth()->user()) ? 'currentColor' : 'none' }}">
                                        <path d="M5 5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H17C17.5304 3 18.0391 3.21071 18.4142 3.58579C18.7893 3.96086 19 4.46957 19 5V21L12 16L5 21V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="d-flex align-items-center">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none me-2">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Комментарии -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Комментарии ({{ $post->comments_count }})</h5>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3" placeholder="Напишите комментарий...">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <p class="mb-2">Чтобы оставить комментарий, <a href="{{ route('login') }}">войдите</a> или <a href="{{ route('register') }}">зарегистрируйтесь</a></p>
                        </div>
                    @endauth

                    @if($post->comments->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Пока нет комментариев. Будьте первым!</p>
                        </div>
                    @else
                        <div class="comments-list">
                            @foreach($post->comments as $comment)
                                <div class="comment mb-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <x-user-avatar :user="$comment->user" :size="40" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <a href="{{ route('users.show', $comment->user) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                                                    <span class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                @can('delete', $comment)
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Вы уверены?')">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                                <path d="M19 7L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 7M10 21V17H14V21M21 7H3M16 7L15.133 4.302C14.9557 3.89822 14.5672 3.5 14 3.5H10C9.43279 3.5 9.04432 3.89822 8.86699 4.302L8 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                            <div class="comment-content">
                                                {{ $comment->content }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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