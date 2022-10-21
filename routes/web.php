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

$router->get('/', 'UserController@index');
$router->post('/info', 'UserController@validation');
$router->get('/info', 'UserController@validation');
$router->get('/add', 'UserController@add');
$router->post('/upload', 'UserController@upload');
$router->get('/show', 'UserController@info');


$router->get('/api/read/info', 'ApiController@read');
$router->get('/api/del/info/', 'ApiController@delById');
