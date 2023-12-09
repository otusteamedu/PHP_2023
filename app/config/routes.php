<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->get('/', \App\Infrastructure\Http\TestAction::class)->setName('test');
    $app->post('/test', \App\Infrastructure\Http\TestActionPost::class);
};
