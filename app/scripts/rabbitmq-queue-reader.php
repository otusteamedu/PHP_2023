<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$callback = function ($msg) {
    echo ' [x] Received ', $msg->getBody(), "\n";
    mail('prizman201@gmail.com', 'Test', $msg->getBody());
    echo " [x] Done\n";
};

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq', '5672', 'guest', 'guest');
$channel = $connection->channel();
$queueName = 'bank';
//$channel->queue_declare($queueName, false, true, false, false);
$res = $channel->basic_consume($queueName, '', false, true, false, false, $callback);

//$channel->close();
//$connection->close();