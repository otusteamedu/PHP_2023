<?php

use Common\Infrastructure\Route;
use Common\Infrastructure\RouteGroup;

return [
    new Route(
        '/',
        'main_page',
        [
            \Common\Infrastructure\Controller::class,
            'index'
        ],
        'get'
    ),
    new Route(
        '/',
        'order',
        [
            \Common\Infrastructure\Controller::class,
            'order'
        ],
        'post'
    )
];
