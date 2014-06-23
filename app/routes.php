<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('/', function()
{
	return View::make('hello');
});
*/
/*Route::get('/', 'HomeController@showWelcome');
Route::get('users','UserController');*/
Route::resource('/', 'DashboardController');
Route::resource('getData', 'DashboardController@getdata');
Route::resource('updateSolution', 'DashboardController@updateSolution');
Route::resource('warga', 'WargaController');
Route::resource('kriteria', 'KriteriaController');
Route::resource('config', 'ConfigController');
Route::resource('user', 'UserController');