<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('story/{name}', 'StoryController@show');
Route::post('story/{name}', 'StoryController@process');

Route::get('restart/{name}', 'StoryController@restart');
Route::get('current/{name}', 'StoryController@current');
Route::get('first/{name}', 'StoryController@first');
Route::post('first/{name}', 'StoryController@first_process');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
