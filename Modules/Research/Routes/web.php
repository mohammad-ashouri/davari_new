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

Route::prefix('research')->group(function () {
    Route::resource('/research-posts', PostController::class);

    Route::prefix('research-movement')->group(function () {
        Route::post('/send', [MovementController::class, 'store'])->name('movement.store');
        Route::get('/posts/history/{post}', [MovementController::class, 'history'])->name('movement.history');
    });
});
