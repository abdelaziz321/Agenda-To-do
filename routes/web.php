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

// Task Routes
Route::get('/', 'TasksController@index');
Route::resource('tasks', 'TasksController', ['only' => ['store', 'update', 'destroy']]);
Route::post('tasks/move/{id}', 'TasksController@move')->name('tasks.move');  #update the deadline
Route::post('tasks/restore/{id}', 'TasksController@restore')->name('tasks.restore');  #restore after delete

// Note Routes
Route::get('notes/dialog', 'NotesController@getNoteDialog');
Route::resource('notes', 'NotesController', ['except' => ['index', 'create', 'edit']]);

// User profile Routes
Route::get('user/index', 'UsersController@index');      #to get the profile section
Route::post('user/update', 'UsersController@update');   #update user info
Route::get('user/skin', 'UsersController@updateSkin');  #change the skin[board]

// Authantication Routes
Route::get('authanticate', 'Auth\RegisterController@showRegistrationForm')->name('login');   #sign in|up
Route::post('authanticate/register', 'Auth\RegisterController@register');   #signup
Route::post('authanticate/login', 'Auth\LoginController@login');            #signin
Route::post('authanticate/logout', 'Auth\LoginController@logout');          #logout

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
