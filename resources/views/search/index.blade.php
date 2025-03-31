@extends('layouts.app')

@section('title', 'Поиск')

@section('content')
<div class="row">
    <!-- Основной контент -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Результаты поиска</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('search.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Поиск по постам и вопросам...">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                @if(request()->has('q'))
                    @if($posts->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <p class="text-muted">По вашему запросу ничего не найдено</p>
                        </div>
                    @else
                        <div class="posts-list">
                            @foreach($posts as $post)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0">
                                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a>
                                        </h5>
                                        <span class="badge bg-{{ $post->type === 'post' ? 'primary' : 'success' }}">
                                            {{ $post->type === 'post' ? 'Запись' : 'Вопрос' }}
                                        </span>
                                    </div>
                                    <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="tags">
                                            @foreach($post->tags as $tag)
                                            <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none">{{ $tag->name }}</a>
                                            @endforeach
                                        </div>
                                        <div class="post-meta">
                                            <small class="text-muted">
                                                Автор: <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none">{{ $post->user->name }}</a>
                                                • {{ $post->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Введите поисковый запрос</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Боковая панель -->
    <div class="col-md-4">
        <!-- Популярные теги -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Популярные теги</h5>
            </div>
            <div class="card-body">
                <div class="tags-cloud">
                    @foreach($popularTags as $tag)
                    <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none me-2 mb-2">
                        {{ $tag->name }}
                        <span class="badge bg-light text-dark">{{ $tag->posts_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Подсказки по поиску -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Подсказки по поиску</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Используйте кавычки для поиска точной фразы
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Добавьте тег для поиска по конкретной теме
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Используйте операторы AND, OR для сложных запросов
                    </li>
                    <li>
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Добавьте минус перед словом для исключения из поиска
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 