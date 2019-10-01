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

if (!request()->ajax()) {
    Route::get('/{any}', function () {
        return view('spa');
    })->where('any', '.*');
}

Route::get('/', function () {
    return view('home');
});

Route::get('/base-info', function () {
    return response()->json(['app_name' => config('app.name', 'School Schedule'), 'user' => Auth::guest() ? null : Auth::user()]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/roles', 'UserController@roles')->name('users.roles');
Route::resource('users', 'UserController');
Route::resource('grades', 'GradeController');

Route::prefix('lessons')->name('lessons.')->group(function() {
    Route::get('create', 'LessonController@create')->name('create');
    Route::post('', 'LessonController@store')->name('store');
    Route::put('{lesson}', 'LessonController@update')->name('update');
    Route::get('{lesson}/edit', 'LessonController@edit')->name('edit');
    Route::delete('{lesson}', 'LessonController@destroy')->name('destroy');
});

