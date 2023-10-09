<?php

// $pdo = new \PDO("pgsql:host=otus-hw-postgres;port=5432;dbname=test;","test", "test");

// $selectPdoStatement = $pdo->prepare(
//     "SELECT * FROM test WHERE id = :id"
// );


// $selectPdoStatement->setFetchMode(\PDO::FETCH_ASSOC);
//         $selectPdoStatement->execute(['id' => 1]);
//         $filmParams = $selectPdoStatement->fetch();


// var_dump($filmParams);



require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new AMQPStreamConnection('rabbit-mq', 5672, 'user', 'password');
$channel = $connection->channel();


$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";


$channel->close();
$connection->close();
