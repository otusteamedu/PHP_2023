<?php

declare(strict_types=1);

namespace Ndybnov\Hw04;

require __DIR__ . '/../vendor/autoload.php';

use Ndybnov\Hw04\hw\MainCommand;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


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
