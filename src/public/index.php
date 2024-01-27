<?php declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Bunny\Client;

$client = new Client([
    'host'      => 'localhost:5673',
    'vhost'     => '/',
    'user'      => 'guest',
    'password'  => 'guest',
]);

$client->connect();
$channel = $client->channel();

$channel->queueDeclare('simple', durable: true);
$channel->publish('{"hello": "world"}', routingKey: 'simple');