<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ExportController;

Route::redirect('/', '/login');

Route::get('/dashboard', [ProfileController::class, 'showProfile'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/archive', [PostController::class, 'archiveIndex'])->name('archives.index');
    Route::post('/posts/{post}/archive', [PostController::class, 'archive'])->name('posts.archive');
    Route::patch('/archives/{id}/restore', [ArchiveController::class, 'restore'])->name('archives.restore');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/archives/export', [ExportController::class, 'export'])->name('archives.export');

    
});

require __DIR__.'/auth.php';
