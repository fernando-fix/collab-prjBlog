<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::any('/ping', function (Request $request) {
    return [
        'pong' => true
    ];
});

Route::post('/register', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);

Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'show', 'destroy']);
Route::resource('posts', PostController::class)->only(['index', 'store', 'update', 'show', 'destroy']);
Route::resource('comments', CommentController::class)->only(['store', 'update', 'destroy']);
Route::resource('tags', TagController::class)->only(['index']);
