<?php

// sample client-request:
// curl -X POST -H "Content-Type: application/json" -d '{"string": "()()()"}' http://0.0.0.0:8181/

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;


$client = new Client();

$host = $argv[1] ?? 'http://0.0.0.0:8181';
$uri = '/';

$str = $argv[2] ?? '(()()()()))((((()()()))(()()()(((()))))))';
try {
    $response = $client->post($host . $uri, [
        'Content-Type' => 'application/json',
        'json' => ['string' => $str]
    ]);

    header('Content-Type: application/json; charset=utf-8');
    echo $response->getBody()->getContents();
} catch (Exception $exception) {
    header('Content-Type: application/json; charset=utf-8');
    echo $exception->getMessage();
}
