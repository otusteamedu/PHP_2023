<?php

declare(strict_types=1);

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Twent\Hw12\Controllers\EventController;

$routes = new RouteCollection();

$routes->add(
    'event_list',
    new Route('/', ['_controller' => [EventController::class, 'index']])
);

$routes->add(
    'event_create',
    new Route('/event/create', ['_controller' => [EventController::class, 'create']])
);

$routes->add(
    'event_find',
    new Route('/event/find-by-conditions', ['_controller' => [EventController::class, 'findByConditions']])
);

$routes->add(
    'event_show',
    new Route('/event/{id}', ['_controller' => [EventController::class, 'show']])
);

return $routes;
