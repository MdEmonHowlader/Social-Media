<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create', [PostController::class, 'create'])->name('post.create');
    Route::get('/', [PostController::class, 'index'])->name('dashboard');

    Route::post('/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('post.delete');

    Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('post.show');

});

require __DIR__.'/auth.php';
