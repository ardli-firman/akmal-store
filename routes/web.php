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

$router->group(['prefix' => 'product'], function () use ($router) {
    $router->get('/', 'ProductController@index');
    $router->get('/{productId}', 'ProductController@show');
    $router->get('/image/{imageName}', 'ProductController@showImage');
    $router->post('/store', 'ProductController@store');
    $router->delete('/destroy/{productId}', 'ProductController@destroy');
});

$router->group(['prefix' => 'category'], function () use ($router) {
    $router->get('/', 'CategoryController@index');
    $router->get('/{categoryId}', 'CategoryController@show');
    $router->post('/store', 'CategoryController@store');
    $router->delete('/destroy/{categoryId}', 'CategoryController@destroy');
});

$router->group(['prefix' => 'customer'], function () use ($router) {
    $router->get('/', 'CustomerController@index');
    $router->post('/store', 'CustomerController@store');
    $router->delete('/destroy/{customerId}', 'CustomerController@destroy');

    $router->get('/{customerId}', 'CustomerController@show');

    $router->get('/{customerId}/order', 'CustomerOrderController@index');
    $router->get('/{customerId}/[order/{orderId}]', 'CustomerOrderController@show');
});
