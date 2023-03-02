<?php

use Imitronov\Hw4\Controller\HomeController;

$routes = [
    'get' => [
        '/' => [HomeController::class, 'index'],
    ],
    'post' => [
        '/' => [HomeController::class, 'validation'],
    ],
];
