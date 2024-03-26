<?php

declare(strict_types=1);

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'orders'], function () use ($router) {
    $router->get('/', 'OrderListController@run');
    $router->get('/{id}', 'OrderInfoController@run');
    $router->post('/', 'OrderCreateController@run');
    $router->put('/{id}', 'OrderUpdateController@run');
    $router->delete('/{id}', 'OrderDeleteController@run');
});
