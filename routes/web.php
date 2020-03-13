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

Route::prefix('/')->group(function(){
    Route::get('/add', ['as' => 'Bookmarks.Add', 'uses' => 'Bookmarks@Add']);
    Route::post('/create', ['as' => 'Bookmarks.Create', 'uses' => 'Bookmarks@Create']);
});
