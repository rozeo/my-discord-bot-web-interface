<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('discord-auth')->group(function () {
    Route::get('/', 'IndexController@index')
    ->name('home');

    Route::get('/upload', 'UploadController@index')
        ->name('upload.index');

    Route::post('/upload', 'UploadController@upload')
        ->name('upload.post');
});

Route::get('/oauth/callback', 'IndexController@callback')
    ->name('oauth.callback');