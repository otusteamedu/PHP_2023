<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use SwaggerLume\Facades\SwaggerLume;
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

$router->get('api/documentation', function () {
    return redirect('/api/documentation/index.html');
});

$router->group(['namespace' => '\App\Modules\Orders\Infrastructure\Controllers'], function () use ($router) {
    require __DIR__ . '/../app/Modules/Orders/Infrastructure/Http/Routes/orders_routes.php';
});
