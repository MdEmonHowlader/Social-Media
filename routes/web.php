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
    
    // Image management routes
    Route::get('/images', [AdminController::class, 'images'])->name('images');
    Route::post('/images', [AdminController::class, 'storeImage'])->name('images.store');
    Route::get('/images/{image}', [AdminController::class, 'getImage'])->name('images.get');
    Route::put('/images/{image}', [AdminController::class, 'updateImage'])->name('images.update');
    Route::delete('/images/{image}', [AdminController::class, 'deleteImage'])->name('images.delete');
});

// Categories management - admin only
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories', [PostController::class, 'categoriesPage'])->name('categories.page');
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

    Route::get('/@{username}/posts', [PublicProfileController::class, 'show'])->name('profile.posts');
    Route::get('/@{username}/following', [PublicProfileController::class, 'following'])->name('following');
    Route::get('/@{username}/followers', [PublicProfileController::class, 'followers'])->name('followers');
    Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('post.show');
    Route::get('/@{username}', [PublicProfileController::class, 'show'])->name('profile.show');

    Route::get('/categories/{category}', [PostController::class, 'category'])->name('post.category');

    Route::post('/@{username}/follow', [FollowController::class, 'store'])->name('follow');
    Route::delete('/@{username}/unfollow', [FollowController::class, 'destroy'])->name('unfollow');
    Route::post('/posts/{post}/clap', [PostClapController::class, 'clap'])->name('clap');
    Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/ai-chat', [AiChatController::class, 'chat'])->name('ai.chat');
});

// Public routes
require __DIR__ . '/auth.php';

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
