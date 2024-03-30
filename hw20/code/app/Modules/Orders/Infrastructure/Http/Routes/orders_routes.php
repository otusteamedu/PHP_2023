<?php

declare(strict_types=1);

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/v1/orders'], function () use ($router) {
    $router->post('/', 'OrderCreateController@run');
    $router->put('/{uuid}', 'OrderUpdateController@run');
    $router->delete('/{uuid}', 'OrderDeleteController@run');
    $router->get('/', 'OrderListController@run');
    $router->get('/{uuid}', 'OrderInfoController@run');
});
