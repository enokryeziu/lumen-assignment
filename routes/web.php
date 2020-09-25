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
use Illuminate\Support\Str;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/user'], function() use($router){
    $router->post('register', 'UserController@register');
    $router->post('login', 'UserController@login');
});
$router->group(['prefix' => 'api/user','middleware' => ['assign.guard:users','auth']], function() use($router){
    $router->get('logout', 'UserController@logout');
    $router->get('' , 'UserController@index');
});


$router->group(['prefix' => 'api/admin'], function() use($router){
    $router->post('register', 'AdminController@register');
    $router->post('login', 'AdminController@login');
});
$router->group(['prefix' => 'api/admin','middleware' => ['assign.guard:admins','auth']], function() use($router){
    $router->get('logout', 'AdminController@logout');
    $router->get('' , 'AdminController@index');
});
