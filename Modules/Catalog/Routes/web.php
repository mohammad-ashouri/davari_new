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

use Modules\InternalPublication\Http\Controllers\InternalPublicationController;

Route::prefix('catalog')->group(function() {
    Route::resource('post-formats', PostFormatController::class);
    Route::resource('scientific-groups', ScientificGroupController::class);
});
