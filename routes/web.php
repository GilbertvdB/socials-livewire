<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// livewire routes
Route::get('comments', [CommentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('comments');

require __DIR__.'/auth.php';
