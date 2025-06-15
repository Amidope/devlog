<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// add admin middleware
Route::apiResources([
    'posts' => PostController::class,
]);

Route::resource('posts/{post}/comments', CommentController::class)->only('index', 'store');
Route::resource('comments', CommentController::class)->only(['update', 'destroy']);
