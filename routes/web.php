<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

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

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/following', [ArticleController::class, 'following_feed'])->name('following_feed');
Route::get('/article/{article:slug}', [ArticleController::class, 'show'])->name('article_show');
Route::get('/search', [ArticleController::class, 'search'])->name('search');

Route::post('/article/{article:slug}/comment', [CommentController::class, 'store'])->name('comment');
Route::post('/article/{article:slug}/reply', [CommentController::class, 'reply'])->name('reply');
Route::delete('/article/{article:slug}/comment/delete', [CommentController::class, 'delete'])->name('comment_delete');

Route::post('/article/toggleLike', [LikeController::class, 'toggleLike']);
Route::post('/article/{article}/checkLikes', [LikeController::class, 'checkLikes']);
Route::post('/article/{article}/checkLiked', [LikeController::class, 'checkLiked']);

Route::post('/comment/toggleLike', [LikeController::class, 'toggleLike']);
Route::post('/comment/{comment}/checkLikes', [LikeController::class, 'checkLikes']);
Route::post('/comment/{comment}/checkLiked', [LikeController::class, 'checkLiked']);

//Route::post('/{type}/toggleLike', [LikeController::class, 'likeComment'])->name('likeComment');

//Route::get('/admin', [AdminController::class, 'login'])->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
