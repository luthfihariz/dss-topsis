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
Route::group(array('before' => 'auth'), function(){
	if(Auth::check()){
		if(Auth::user()->roles == 1){
			Route::resource('user', 'UserController');
			Route::resource('config', 'ConfigController');
		}
		if(Auth::user()->roles == 1 || Auth::user()->roles == 2){
			Route::resource('kriteria', 'KriteriaController');
			Route::resource('report', 'DashboardController@printReport');
			Route::resource('tickets', 'DashboardController@printTickets');
		}				
	}	
	Route::resource('/', 'DashboardController');
	Route::resource('getData', 'DashboardController@getdata');
	Route::resource('updateSolution', 'DashboardController@updateSolution');	
	Route::resource('warga', 'WargaController');	
	Route::resource('logout', 'LoginController@doLogout');
});

Route::resource('login', 'LoginController');
Route::post('login', array('uses' => 'LoginController@doLogin'));