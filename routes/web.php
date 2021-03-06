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

$router->get('/key', function(){
    return  \Illuminate\Support\Str::random(32);
});

$router->get('/productos','ProductsController@index');
$router->post('/productos','ProductsController@createProduct');
$router->post('/productos/update','ProductsController@updateProduct');

$router->post('/carrito_productos','ProductsController@index_carrito');
$router->post('/checkout','ProductsController@CheckOutForm');
