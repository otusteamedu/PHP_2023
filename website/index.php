<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_DATABASE', 'DB_USER', 'DB_USER_PASSWORD']);

try {
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