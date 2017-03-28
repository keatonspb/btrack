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
Route::get('/cabinet/add', 'CabinetController@addTrack');
Route::post('/cabinet/save', 'CabinetController@saveTrack');
Route::get('/cabinet/edit/{id}', 'CabinetController@editTrack');
