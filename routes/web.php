<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FollowController;

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
Route::get('/search', [ArticleController::class, 'search'])->name('search');

Route::get('/{category:name}', [ArticleController::class, 'category'])->name('category');
// Route::post('/{category:name?}/top', [ArticleController::class, 'top'])->name('top');
Route::post('/{category:name}/toggleFollow', [FollowController::class, 'toggleFollow'])->name('userFollow');
Route::post('/cookie/{category:name}/toggleFollow', [CookieController::class, 'toggleCategory'])->name('guestFollow');

Route::get('/article/{article:slug}', [ArticleController::class, 'show'])->name('article_show');
Route::post('/article/{article:slug}/comment', [CommentController::class, 'store'])->name('comment');
Route::post('/article/{article:slug}/reply', [CommentController::class, 'reply'])->name('reply');
Route::delete('/article/{article:slug}/comment/delete', [CommentController::class, 'delete'])->name('comment_delete');

Route::post('/article/toggleLike', [LikeController::class, 'toggleLike']);
Route::post('/article/{article}/checkLikes', [LikeController::class, 'checkLikes']);
Route::post('/article/{article}/checkLiked', [LikeController::class, 'checkLiked']);

Route::post('/comment/toggleLike', [LikeController::class, 'toggleLike']);
Route::post('/comment/{comment}/checkLikes', [LikeController::class, 'checkLikes']);
Route::post('/comment/{comment}/checkLiked', [LikeController::class, 'checkLiked']);

Route::get('/cookie/getColorScheme', [CookieController::class, 'getColorScheme']);
Route::get('/cookie/setColorScheme', [CookieController::class, 'setColorScheme']);
Route::get('/cookie/getFontSize', [CookieController::class, 'getFontSize']);
Route::get('/cookie/setFontSize', [CookieController::class, 'setFontSize']);
Route::get('/cookie/getCategories', [CookieController::class, 'getCategories']);

//Route::post('/{type}/toggleLike', [LikeController::class, 'likeComment'])->name('likeComment');

//Route::get('/admin', [AdminController::class, 'login'])->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
