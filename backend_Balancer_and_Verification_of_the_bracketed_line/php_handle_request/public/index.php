<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->post('/', function (Request $request, Response $response): Response {

    $data = $request->getParsedBody();
    
    $string = $data['string'];

    $isOk = true;
    $statusMessage = 'OK';
    $statusCode = 200;
    if(!$isOk) {
        $statusMessage = 'Bad Request';
        $statusCode = 400;
    }

    $output = json_encode([
        'received' => $string,
        'info' => $statusMessage,
        'scode' => $statusCode,
        'req' => var_export($request, 1),
        'data' => print_r($data, 1),
    ]);

    $response->getBody()->write($output);
    return $response->withStatus($statusCode);
});

$app->run();
