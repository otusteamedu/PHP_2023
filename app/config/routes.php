<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write('Hello, World!');
        return $response;
    });

    $app->get('/hello', function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write('Hello World');
        return $response;
    });
};
