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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/image/{id}', 'ImageController@image')
    ->where(['id' => '[0-9]+'])
    ->name('image-id');
Route::get('/image/current', 'ImageController@current')
    ->name('image-current');
Route::get('/admin', 'AdminController@admin')
    ->name('admin');
Route::get('/next', 'AdminController@next')
    ->name('next');
Route::view('/slideshow', 'slideshow')
    ->name('slideshow');
