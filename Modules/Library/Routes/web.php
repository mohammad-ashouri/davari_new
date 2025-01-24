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

Route::prefix('library')->as('library.')->group(function () {
    Route::resource('/', LibraryController::class);
});
