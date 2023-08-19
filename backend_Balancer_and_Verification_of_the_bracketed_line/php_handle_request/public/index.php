<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->post('/', function (Request $request, Response $response): Response {

    $data = $request->getParsedBody();
    
    $string = $data['string'];

//    $name = $data['name'];
//    $message = $data['message'];
//
//    if ($name == null) {
//        $name = 'guest';
//    }
//
//    if ($message == null) {
//        $message = 'hello there';
//    }

    $isOk = true;
    $statusMessage = 'OK';
    $statusCode = 200;
    if(!$isOk) {
        $statusMessage = 'Bad Request';
        $statusCode = 400;
    }

    //$output = "$name says: $message";
    $output = json_encode([
        //'data' => 'handler-post-method',
        //'msg' => 'It is may be Ok or Fail',
        'received' => $string,
        'info' => $statusMessage,
	'scode' => $statusCode,
	'req' => var_export($request, 1),
	'data' => print_r($data, 1),
        //'code' => 400
    ]);

    $response->getBody()->write($output);
    //$response->withStatus(403);
    //$response->withStatus(402);
    // 200 300
    return $response->withStatus($statusCode);
});

$app->run();

// curl -d "name=Lucia&message=msg" localhost:8000
//
