@extends('layouts.app')

@section('title', 'Закладки')

@section('content')
<div class="container">
    <div class="row">
        <!-- Боковое меню -->
        <x-side-menu />
        @include('components.side-menu-styles')

        <!-- Основной контент -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Закладки</span>
                    @if($bookmarks->isNotEmpty())
                        <form action="{{ route('bookmarks.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Вы уверены?')">
                                Очистить все
                            </button>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    @if($bookmarks->isEmpty())
                        <div class="text-center py-5">
                            <svg class="mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                <path d="M5 5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H17C17.5304 3 18.0391 3.21071 18.4142 3.58579C18.7893 3.96086 19 4.46957 19 5V21L12 16L5 21V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h5>У вас пока нет закладок</h5>
                            <p class="text-muted">Здесь будут появляться посты, которые вы добавите в закладки</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($bookmarks as $bookmark)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1">
                                                <a href="{{ route('posts.show', $bookmark->post) }}" class="text-decoration-none text-dark">
                                                    {{ $bookmark->post->title }}
                                                </a>
                                            </h5>
                                            <div class="d-flex align-items-center text-muted mb-2">
                                                <x-user-avatar :user="$bookmark->post->user" :size="24" class="me-2" />
                                                {{ $bookmark->post->user->name }}
                                            </div>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($bookmark->post->tags as $tag)
                                                    <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none">
                                                        #{{ $tag->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <form action="{{ route('bookmarks.destroy', $bookmark->post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Вы уверены, что хотите удалить эту закладку?')">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $bookmarks->links() }}
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