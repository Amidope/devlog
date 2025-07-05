<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// auth
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

// posts
Route::resource('posts', PostController::class)
    ->only('store', 'update', 'destroy')
    ->middleware(['auth:sanctum', IsAdminMiddleware::class]);
Route::resource('posts', PostController::class)
    ->only('index', 'show');

// comments
Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::resource('comments', CommentController::class)->only(['update', 'destroy']);
});
