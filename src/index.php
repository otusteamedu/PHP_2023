<?php

$redis = new Redis();
$redis->connect('redis', 6379);

var_dump($redis->ping());

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

var_dump($memcached->getVersion());

try {
    $dsn = 'mysql:host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'];
    $dbh = new \PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
