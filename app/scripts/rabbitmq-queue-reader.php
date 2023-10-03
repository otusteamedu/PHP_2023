<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq', '5672', 'guest', 'guest');
$channel = $connection->channel();
$queueName = 'bank';
$channel->queue_declare($queueName, false, true, false, false);
$res = $channel->basic_get($queueName);

var_dump($res);

$channel->close();
$connection->close();