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
    return redirect('twitter/ranking');
});

Route::get('twitter/search/', 'TwitterController@search');
Route::get('twitter/ranking/', 'TwitterController@ranking');
Route::get('twitter/hashtaglist/', 'TwitterController@hashtaglist');
Route::get('twitter/hashtaghistory/{hashtagId?}', 'TwitterController@hashtaghistory');