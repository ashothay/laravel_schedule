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
    return view('spa');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::resource('grades', 'GradeController');

Route::prefix('lessons')->name('lessons.')->group(function() {
    Route::get('create', 'LessonController@create')->name('create');
    Route::post('', 'LessonController@store')->name('store');
    Route::put('{lesson}', 'LessonController@update')->name('update');
    Route::get('{lesson}/edit', 'LessonController@edit')->name('edit');
    Route::delete('{lesson}', 'LessonController@destroy')->name('destroy');
});

