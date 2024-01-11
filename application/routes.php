<?php

use Gesparo\Homework\Infrastructure\Controller\CheckController;
use Gesparo\Homework\Infrastructure\Controller\RequestController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add(
    'request-add',
    new Route(
        path: '/requests',
        defaults: ['_controller' => RequestController::class, '_method' => 'add'],
        methods: ['POST']
    )
);
$routes->add(
    'request-check',
    new Route(
        path: '/requests/{messageId}',
        defaults: ['_controller' => CheckController::class, '_method' => 'get'],
        methods: ['GET']
    )
);

return $routes;