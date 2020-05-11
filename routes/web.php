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

// login user
$router->post('login', 'AuthController@login');
// registrasi user
$router->post('registrasi', 'AuthController@registrasi');

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->group(['prefix' => 'product'], function () use ($router) {
        // get all products
        $router->get('/', 'ProductController@index');
        // get product 
        $router->get('/{productId}', 'ProductController@show');
        // store product
        $router->post('/store', 'ProductController@store');
        // delete product
        $router->delete('/{productId}/destroy', 'ProductController@destroy');
    });

    $router->group(['prefix' => 'category'], function () use ($router) {
        // get all categories
        $router->get('/', 'CategoryController@index');
        // get category
        $router->get('/{categoryId}', 'CategoryController@show');
        // store category
        $router->post('/store', 'CategoryController@store');
        // delete category
        $router->delete('/{categoryId}/destroy', 'CategoryController@destroy');
    });

    $router->group(['prefix' => 'customer'], function () use ($router) {
        // get all customers profile
        $router->get('/', 'CustomerController@index');
        // store customer 
        $router->post('/store', 'CustomerController@store');
        // destroy customer
        $router->delete('/{customerId}/destroy', 'CustomerController@destroy');
        // get customer
        $router->get('/{customerId}', 'CustomerController@show');

        // get all customer order
        $router->get('/{customerId}/order', 'CustomerOrderController@index');
        // get customer order
        $router->get('/{customerId}/[order/{orderId}]', 'CustomerOrderController@show');
        // store customer order
        $router->post('/{customerId}/order/store', 'CustomerOrderController@store');
        // delete customer order
        $router->delete('/{customerId}/order/{orderId}/destroy', 'CustomerOrderController@destroy');
    });
});
// Get image product
$router->get('product/image/{imageName}', 'ProductController@showImage');
