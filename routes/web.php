<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => 'v1'
], function () {


Route::get('/feed/posts', [PostController::class, 'index']);
Route::post('/feed/posts', [PostController::class, 'index']);

Route::get('/login', [AuthController::class, 'index']);

Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/posts', [PostController::class, 'index']);

Route::get('/posts/create', [PostController::class, 'index']);

Route::get('/posts/store', [PostController::class, 'index']);





Route::resources([
    'feed-posts' => FeedPostController::class,
    'feed.posts' => PostController::class,
    'login' => AuthController::class,
    'posts' => PostController::class,
    'posts.create'=> PostController::class,
    'posts.store'=> PostController::class,
    'posts.edit'=> PostController::class,
    'posts.destroy'=> PostController::class,
    'posts-posts' => PostController::class,


]);

});
