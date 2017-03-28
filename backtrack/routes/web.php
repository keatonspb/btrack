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