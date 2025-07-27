<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostClapController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes - protected by admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create', [PostController::class, 'create'])->name('post.create');
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    Route::post('/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('post.delete');

    Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('post.show');
    Route::get('/@{username}', [PublicProfileController::class, 'show'])->name('profile.show');
    Route::get('/@{username}/posts', [PublicProfileController::class, 'show'])->name('profile.posts');
    Route::get('/@{username}/following', [PublicProfileController::class, 'following'])->name('following');
    Route::get('/@{username}/followers', [PublicProfileController::class, 'followers'])->name('followers');

    Route::get('/categories/{category}', [PostController::class, 'category'])->name('post.category');
    Route::get('/categories', [PostController::class, 'categoriesPage'])->name('categories.page');

    Route::post('/@{username}/follow', [FollowController::class, 'store'])->name('follow');
    Route::delete('/@{username}/unfollow', [FollowController::class, 'destroy'])->name('unfollow');
    Route::post('/posts/{post}/clap', [PostClapController::class, 'clap'])->name('clap');
    Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Contact routes (public)
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/ai-chat', [AiChatController::class, 'chat'])->name('ai.chat');
Route::get('/ai-chat/history', [AiChatController::class, 'history'])->name('ai.chat.history');

require __DIR__ . '/auth.php';
