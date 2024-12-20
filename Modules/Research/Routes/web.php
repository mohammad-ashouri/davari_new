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

use Modules\Research\Http\Controllers\MovementController;
use Modules\Research\Http\Controllers\ResearchController;

Route::prefix('research')->as('research.')->group(function () {
    Route::resource('/posts', ResearchController::class);

    Route::prefix('movement')->group(function () {
        Route::post('/send', [MovementController::class, 'store'])->name('movement.store');
        Route::get('/posts/history/{post}', [MovementController::class, 'history'])->name('movement.history');
    });
});
