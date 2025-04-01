@extends('layouts.app')

@section('title', 'Теги')

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
                    <h5 class="mb-0">Теги</h5>
                </div>
                <div class="card-body">
                    @if($tags->isEmpty())
                        <div class="text-center py-5">
                            <img src="{{ asset('images/tag.svg') }}" class="mb-3" width="48" height="48" alt="Теги">
                            <h5>Пока нет тегов</h5>
                            <p class="text-muted">Создайте первый пост, чтобы добавить теги</p>
                        </div>
                    @else
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="badge bg-secondary text-decoration-none p-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/tag.svg') }}" class="me-2" width="20" height="20" alt="Тег" style="filter: brightness(0) invert(1);">
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
            <div class="card">
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
        </div>
    </div>
</div>
@endsection 