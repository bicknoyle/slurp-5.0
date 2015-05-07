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

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('connect/twitter', ['as' => 'connect.twitter', 'uses' => 'HomeController@connectTwitter']);
Route::get('connect/twitter/callback', 'HomeController@connectTwitterCallback');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::model('searches', 'App\Search');
Route::resource('searches', 'SearchController');
Route::get('searches/{searches}/results', ['as' => 'searches.results', 'uses' => 'SearchController@results']);
Route::get('searches/{searches}/results/download', ['as' => 'searches.results.download', 'uses' => 'SearchController@resultsDownload']);