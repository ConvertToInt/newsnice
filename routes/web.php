<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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
Route::post('/article/{article:slug}/comment', [CommentController::class, 'store'])->name('comment');
Route::post('/article/{article:slug}/reply', [CommentController::class, 'reply'])->name('reply');
Route::delete('/article/{article:slug}/comment/delete', [CommentController::class, 'delete'])->name('comment_delete');
Route::get('/{user}/settings', [UserController::class, 'show'])->name('settings');
Route::patch('/{user}/update', [UserController::class, 'update'])->name('settings_update');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
