<?php

use Predis\Response\Status;

require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=mysql;database=test', '', '');
    echo 'DB connection works!' . '<br/>';
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}

$client = new Predis\Client([
    'host' => 'redis',
    'port' => '6379'
]);
$client->connect();

/** @var Status $response */
$response = $client->ping();
if ($response->getPayload() === 'PONG') {
    echo 'Redis connection works!' . '<br/>';
}

$mc = new Memcached();
if ($mc->addServer('memcached', 11211)) {
    echo 'Memcached connection works!';
}
