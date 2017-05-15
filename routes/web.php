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
Route::get('/', 'WelcomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index');

Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');

    Route::resource('member', 'MemberController');

    Route::get('list', ['uses' => 'MemberController@getList']);
    Route::post('add', ['uses' => 'MemberController@postAdd']);
    Route::get('edit/{id}', ['uses' => 'MemberController@getEdit']);
    Route::post('edit/{id}', ['uses' => 'MemberController@postEdit']);
    Route::get('delete/{id}', ['as'=>'admin.edit','uses' => 'MemberController@getDelete']);
});