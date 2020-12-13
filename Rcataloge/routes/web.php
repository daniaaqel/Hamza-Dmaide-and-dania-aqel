<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
	return response()->json(['Message' => 'Welcome to RCatalogue server.']);
});

$router->group(['prefix' => 'query'], function($router){
	$router->get('booktopic/{topic}','RCatalogueController@showRelatedBooks');
	$router->get('bookid/{id}', 'RCatalogueController@showOneBook');
	$router->get('check/{id}', 'RCatalogueController@checkStore');
});

$router->group(['prefix' => 'update'], function($router){
	$router->get('buy/{id}', 'RCatalogueController@buyBook');
});
