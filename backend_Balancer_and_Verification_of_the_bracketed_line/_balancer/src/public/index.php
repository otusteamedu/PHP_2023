<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\public;

require __DIR__ . '/../vendor/autoload.php';


use Ndybnov\Hw04\hw\MainCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


$app = AppFactory::create();

$app->post('/', function (Request $request, Response $response): Response {

    $result = MainCommand::build()->run($request);

    $body = [
        'received' => $result->getString(),
        'info' => $result->getInfoMessage(),
    ];

    $response->getBody()->write(json_encode($body, JSON_THROW_ON_ERROR));

    return $response->withStatus($result->getStatusCode());
});

$app->run();
