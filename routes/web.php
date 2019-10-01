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

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::resource('grades', 'GradeController');

Route::get('lessons/create', 'LessonController@create')->name('lessons.create');
Route::post('lessons', 'LessonController@store')->name('lessons.store');
Route::put('lessons/{lesson}', 'LessonController@update')->name('lessons.update');
Route::get('lessons/{lesson}/edit', 'LessonController@edit')->name('lessons.edit');
Route::delete('lessons/{lesson}', 'LessonController@destroy')->name('lessons.destroy');
