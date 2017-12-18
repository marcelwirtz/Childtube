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
    return view('welcome')->with('playlists', \App\Playlist::all());
});

Auth::routes();

Route::get('/playlist', 'PlaylistController@index')->name('playlist.index')->middleware('auth');
Route::get('/playlist/show/{playlist}/{pageToken?}', 'PlaylistController@show')->name('playlist.show');
Route::get('/playlist/create', 'PlaylistController@create')->name('playlist.create')->middleware('auth');
Route::get('/playlist/{playlist}/delete', 'PlaylistController@destroy')->name('playlist.delete')->middleware('auth');
Route::post('/playlist', 'PlaylistController@store')->name('playlist.store')->middleware('auth');

Route::get('/home', 'HomeController@index');
