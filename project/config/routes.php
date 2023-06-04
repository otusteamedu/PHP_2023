<?php

declare(strict_types=1);

return [
    '/api/v1/orders' => [
        'method' => 'POST',
        'controller' => \Vp\App\Infrastructure\Controllers\Order::class,
        'action' => 'create',
        'middleWare' => ['json', 'auth']
    ],
    '/api/v1/orders/{id}' => [
        'method' => 'GET',
        'controller' => \Vp\App\Infrastructure\Controllers\Order::class,
        'action' => 'getStatus',
        'middleWare' => ['auth']
    ],
];
