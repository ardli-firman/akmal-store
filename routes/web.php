<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Router;

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

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');
});

$router->get('/user', ['middleware' => 'auth', function (Request $request) {
    return Auth::user();
}]);

$router->get('/api-key', function () {
    return Str::random(64);
});

$router->get('/test', 'ProductController@index');
