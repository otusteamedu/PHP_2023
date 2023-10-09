<?php


require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbit-mq', 5672, 'user', 'password');
$channel = $connection->channel();


$queueName = 'account_statement';
$channel->queue_declare($queueName, false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";


$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
    sleep(5);
    $msg->ack();
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume($queueName, '', false, false, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}


$channel->close();
$connection->close();
