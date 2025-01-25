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

use Modules\Library\Http\Controllers\LibraryController;

Route::prefix('library')->group(function () {
    Route::resource('/', LibraryController::class);
    Route::get('/{id}', [LibraryController::class, 'show'])->name('library.show');
    Route::post('/{id}', [LibraryController::class, 'update'])->name('library.update');
    Route::delete('/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');
});
