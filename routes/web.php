<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api/v1'], function ($router) {
	$router->post('login','UserController@login');
	$router->post('register','UserController@register');
	
	$router->group(['middleware' => 'auth'], function($router) {
		$router->get('users','UserController@users');
		$router->get('candidates', 'CandidateController@index');
		$router->post('candidates', 'CandidateController@store');
		$router->get('candidates/{id}', 'CandidateController@getCandidate');
		$router->post('candidates/search', 'CandidateController@search');
	});
});