<?php

// sample client-request:
// curl -X POST -H "Content-Type: application/json" -d '{"string": "()()()"}' http://0.0.0.0:8181/

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;


$hostLikeCommandLineParameter = $argv[1] ?? null;
$strLikeCommandLineParameter = $argv[2] ?? null;


$client = new Client();

$host = $hostLikeCommandLineParameter ?? 'http://0.0.0.0:8181';
$uri = '/';
//$uri = '/?string=(())';

//$body = ['string' => 'bla-bla'];
//$body = [];
//$body = ['string' => ''];
//$body = ['string' => '())(()'];
//$body = ['string' => '()()'];
$str = $strLikeCommandLineParameter ?? '(()()()()))((((()()()))(()()()(((()))))))';
$body = ['string' => $str];

$msg = '';
$isOk = true;
try {
    $response = $client->post($host . $uri, [
        'Content-Type' => 'application/json',
        'json' => $body
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
