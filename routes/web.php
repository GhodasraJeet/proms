<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});


Auth::routes();
Route::get('profile','ProfileController@index')->name('profile.index');
Route::post('profile/update','ProfileController@update')->name('profile.update');


Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Project's route
Route::get('projects','ProjectController@index')->name('projects.index');
Route::post('projects','ProjectController@index')->name('projects.index');
Route::post('projects/store','ProjectController@store')->name('projects.store');
Route::get('projects/show/{id?}','ProjectController@show')->name('projects.show');
Route::post('projects/update/{id?}','ProjectController@update')->name('projects.update');

Route::post('involeduserproject','ProjectController@involeduser')->name('user.involeduser');
Route::post('updateuserproject','ProjectController@updateuserproject')->name('user.updateuserproject');

// Users's route
Route::get('users','UserController@index')->name('users.index');
Route::post('users/store','UserController@store')->name('users.store');
Route::get('users/list','UserController@list')->name('users.list');

// Stage's Route
Route::post('stage/store','StageController@store')->name('stage.store');
Route::get('stage/list/{projectid?}','StageController@list')->name('stage.list');
Route::get('stage/destroy/{id?}','StageController@destroy')->name('stage.destroy');

// Task's Route
Route::post('tasks/updatestage','TaskController@update_stage_task')->name('tasks.updatestage');
Route::post('tasks/store','TaskController@store')->name('tasks.store');
Route::get('tasks/show/{id?}','TaskController@show')->name('tasks.show');
Route::post('tasks/updatestatus','TaskController@update_task_status')->name('tasks.updatestatus');
Route::get('userslist','UserController@userslist')->name('userslist');



Route::post('global','GlobalController@routelist')->name('routes.list');
