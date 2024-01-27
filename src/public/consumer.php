<?php declare(strict_types=1);

require_once __DIR__.'/../../vendor/autoload.php';

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;

$client = new Client([
    'host'      => 'localhost:5673',
    'vhost'     => '/',
    'user'      => 'guest',
    'password'  => 'guest',
]);

try {
    $client->connect();
} catch (Exception $e) {
    die($e->getMessage());
}

$channel = $client->channel();

$channel->qos(prefetchCount: 1);

$channel->consume(function (Message $message, Channel $channel): void {
    var_dump($message->content);
    $channel->ack($message);
}, 'simple');

$client->run();