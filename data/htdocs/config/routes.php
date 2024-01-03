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
    new RouteGroup(
        '/api',
        'api',
        [
            new RouteGroup(
                '/api/v1',
                'v1',
                [
                    new Route(
                        '/api/v1/ad',
                        'ad_list',
                        [
                            \Ad\Infrastructure\Controller::class,
                            'index'
                        ],
                        'get'
                    ),
                    new Route(
                        '/api/v1/ad',
                        'ad_add',
                        [
                            \Ad\Infrastructure\Controller::class,
                            'add'
                        ],
                        'post'
                    ),
                ]
            )
        ]
    )
];