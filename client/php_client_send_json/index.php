<?php

// sample client-request:
// curl -X POST -H "Content-Type: application/json" -d '{"string": "()()()"}' http://0.0.0.0:8181/

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$router = new AltoRouter();
$client = new Client();

$host = 'http://0.0.0.0:8181';
$uri = '/';

//$body = ['String' => 'bla-bla'];

$msg = '';
$isOk = true;
try {
    $response = $client->post($host . $uri, [
        'Content-Type' => 'application/json',
        'json' => [
                'string' => '())(()',
        ],
    ]);
} catch (Exception $exception) {
    $msg = $exception->getMessage();
    echo $msg;
    echo PHP_EOL;
    $isOk = false;
}

if ($isOk) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'data' => json_decode($response->getBody()->getContents()),
        'status-code' => json_decode($response->getStatusCode()),
        'size' => json_decode($response->getBody()->getSize()),
        'msg' => $msg,
    ]);

    echo PHP_EOL;
}

$match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    //header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
