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
    'event_show',
    new Route('/event/{id}', ['_controller' => [EventController::class, 'show']])
);

return $routes;
