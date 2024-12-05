<?php

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

use Modules\InternalPublication\Http\Controllers\PostController;

Route::prefix('internal-publication')->group(function () {
    Route::resource('/posts', PostController::class);
    Route::get('/posts/history/{post}', [PostController::class,'history'])->name('posts.history');
});
