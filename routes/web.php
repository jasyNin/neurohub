<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserRatingController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\DraftController;
use Illuminate\Http\Request;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Статические страницы
Route::get('/rules', [PageController::class, 'rules'])->name('rules');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/help', [PageController::class, 'help'])->name('help');

// Аутентификация
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Защищенные маршруты
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Профиль
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Уведомления
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::put('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    
    // Закладки
    Route::get('bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::delete('bookmarks/clear', [BookmarkController::class, 'clear'])->name('bookmarks.clear');
    Route::delete('bookmarks/{post}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::post('posts/{post}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');
    
    // Рейтинги
    Route::post('posts/{post}/rate', [PostController::class, 'rate'])->name('posts.rate');
    
    // Комментарии
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::post('comments/{comment}/dislike', [CommentController::class, 'dislike'])->name('comments.dislike');

    Route::get('drafts', [DraftController::class, 'index'])->name('drafts.index');
});

// Посты
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('questions', function (Request $request) {
    return app(PostController::class)->index($request->merge(['type' => 'question']));
})->name('questions.index');

Route::middleware('auth')->group(function () {
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('posts/{post}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');

// Пользователи
Route::get('users/rating', [UserController::class, 'rating'])->name('users.rating');
Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

// Теги
Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::get('tags/{tag}', [TagController::class, 'show'])->name('tags.show');

// Поиск
Route::get('search', [SearchController::class, 'index'])->name('search.index');

Route::get('/answers', [AnswerController::class, 'index'])->name('answers.index');
