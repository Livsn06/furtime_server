<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/users',);


Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/session', [AuthenticationController::class, 'session'])->middleware('auth:sanctum');

Route::apiResource('comments', CommentController::class)->middleware('auth:sanctum');
Route::get('/post/{id}/comments', [CommentController::class, 'getCommentByPostId']);

Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');
