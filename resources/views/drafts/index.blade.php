@extends('layouts.app')

@section('title', 'Черновики')

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
                    <h5 class="mb-0">Черновики</h5>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">
                        <svg class="me-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Новый пост
                    </a>
                </div>
                <div class="card-body">
                    @if($drafts->isEmpty())
                        <div class="text-center py-5">
                            <svg class="mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13M18.5 2.50001C18.8978 2.10219 19.4374 1.87869 20 1.87869C20.5626 1.87869 21.1022 2.10219 21.5 2.50001C21.8978 2.89784 22.1213 3.43739 22.1213 4.00001C22.1213 4.56262 21.8978 5.10219 21.5 5.50001L12 15L8 16L9 12L18.5 2.50001Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h5>У вас пока нет черновиков</h5>
                            <p class="text-muted">Создайте новый пост, чтобы начать писать</p>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                Создать пост
                            </a>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($drafts as $draft)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $draft->title }}</h6>
                                            <small class="text-muted">Последнее обновление: {{ $draft->updated_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="btn-group">
                                            <a href="{{ route('posts.edit', $draft) }}" class="btn btn-sm btn-outline-primary">
                                                <svg class="me-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13M18.5 2.50001C18.8978 2.10219 19.4374 1.87869 20 1.87869C20.5626 1.87869 21.1022 2.10219 21.5 2.50001C21.8978 2.89784 22.1213 3.43739 22.1213 4.00001C22.1213 4.56262 21.8978 5.10219 21.5 5.50001L12 15L8 16L9 12L18.5 2.50001Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Редактировать
                                            </a>
                                            <form action="{{ route('posts.destroy', $draft) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Вы уверены, что хотите удалить этот черновик?')">
                                                    <svg class="me-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                        <path d="M19 7L18.1327 19.3525C18.0579 20.4495 17.187 21.25 16.089 21.25H7.91103C6.81296 21.25 5.94208 20.4495 5.86732 19.3525L5 7M10 21V10.5M14 21V10.5M3 7H21M16 7L15.133 3.25452C14.9163 2.43851 14.1932 1.875 13.372 1.875H10.628C9.80676 1.875 9.08365 2.43851 8.86697 3.25452L8 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $drafts->links() }}
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