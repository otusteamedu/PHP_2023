<?php

use Dotenv\Dotenv;
use PhpAmqpLib\Connection\AMQPStreamConnection;

error_reporting(E_ALL & ~E_DEPRECATED);

require 'vendor/autoload.php';

try {
    session_start();
    echo 'Redis: OK<br />';
} catch (RuntimeException $e) {
    echo $e->getMessage();
}

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

try {
    $dotenv->required(['DB_HOST', 'DB_DATABASE', 'DB_USER', 'DB_USER_PASSWORD']);
    $pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_DATABASE']),
        $_ENV['DB_USER'],
        $_ENV['DB_USER_PASSWORD']
    );
    $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    $pdo->exec('SHOW TABLES;');

    echo 'Mysql: OK<br />';
} catch (RuntimeException $e) {
    echo $e->getMessage();
}

try {
    $dotenv->required(['RABBITMQ_DEFAULT_USER', 'RABBITMQ_DEFAULT_PASS']);
    $connection = new AMQPStreamConnection(
        'rabbitmq',
        5672,
        $_ENV['RABBITMQ_DEFAULT_USER'],
        $_ENV['RABBITMQ_DEFAULT_PASS']
    );
    $channel = $connection->channel();
    $channel->queue_declare('hello', false, false, false, false);

    $channel->close();
    $connection->close();

    echo 'RabbitMQ: OK<br />';
} catch (RuntimeException $e) {
    echo $e->getMessage();
}

try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $memcached->getAllKeys();

    echo 'Memcached: OK<br />';
} catch (RuntimeException $e) {
    echo $e->getMessage();
}
