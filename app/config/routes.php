<?php

use Imitronov\Hw12\Infrastructure\Controller\EventController;

$routes = [
    'get' => [
        '/events/search' => [EventController::class, 'search'],
    ],
    'post' => [
        '/events' => [EventController::class, 'create'],
    ],
    'delete' => [
        '/events' => [EventController::class, 'clear'],
    ],
];
