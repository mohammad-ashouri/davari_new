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

use Modules\Catalog\Http\Controllers\LanguageController;
use Modules\Catalog\Http\Controllers\PostFormatController;
use Modules\Catalog\Http\Controllers\PostSubjectController;
use Modules\InternalPublication\Http\Controllers\InternalPublicationController;

Route::prefix('catalog')->group(function () {
    Route::get('/post-formats/get-all', [PostFormatController::class,'allPostFormats']);
    Route::resource('post-formats', PostFormatController::class);
    Route::resource('scientific-groups', ScientificGroupController::class);
    Route::get('/languages/get-all', [LanguageController::class,'allLanguages']);
    Route::resource('languages', LanguageController::class);
    Route::get('/post-subjects/get-all', [PostSubjectController::class,'allPostSubjects']);
    Route::resource('post-subjects', PostSubjectController::class);
});
