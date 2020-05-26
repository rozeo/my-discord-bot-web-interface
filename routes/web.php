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

Route::get('/', 'IndexController@index')
    ->name('index');

Route::middleware('discord-auth')->group(function () {
    Route::get('/home', 'IndexController@home')
    ->name('home');

    route::prefix('/music')->group(function () {
        Route::get('/list', 'MusicController@list')
            ->name('music.list');

        Route::get('/upload', 'MusicController@index')
            ->name('music.index');

        Route::post('/upload', 'MusicController@upload')
            ->name('music.post');

        Route::get('/detail/{name?}', 'MusicController@detail')
            ->name('music.detail');
    });

    Route::get('/logout', 'IndexController@logout');
});

Route::get('/oauth/callback', 'IndexController@callback')
    ->name('oauth.callback');

Route::get('/storage/music/{name?}', 'FileController@index')
    ->name('storage.music');