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


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/cabinet/song/add', 'CabinetController@addSong');
Route::post('/cabinet/song/submit', 'CabinetController@submitSong');
Route::post('/cabinet/song/save', 'CabinetController@saveSong');
Route::get('/cabinet/song/edit/{id}', 'CabinetController@editSong');
Route::get('/cabinet/track/edit/{id}', 'CabinetController@editTrack');
Route::post('/cabinet/track/save', 'CabinetController@saveTrack');
Route::get('/song/{id}', 'HomeController@song');
Route::get('/song/{id}/{track_id}', 'HomeController@song');
Route::post('/cabinet/tabs/save', 'TabController@save');
Route::get('/cabinet/tabs/get/{id}', 'TabController@get');
Route::get('/cabinet/tabs/{tab}/delete', 'TabController@delete');
Route::get("/cabinet/track/delete/{track}", 'CabinetController@deleteTrack');

Route::get("/search", 'SearchController@search');