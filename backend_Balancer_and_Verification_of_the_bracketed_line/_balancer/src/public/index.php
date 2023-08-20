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
        'info' => $result->getStatusMessage(),
        'status-code' => $result->getStatusCode(),
    ];
    if(4 === $result->getCodeStatus()) {
        $body['position'] = $result->getPositionDetectedError();
    }

    $response->getBody()->write(json_encode($body));

    return $response->withStatus($result->getStatusCode());
});

$app->run();
