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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/note/show', 'NoteController@shownote');
Route::post('/storenote', 'NoteController@storenote');
Route::get('/note/edit/{id}', 'NoteController@showedit');
Route::post('/note/update/{id}', 'NoteController@update');