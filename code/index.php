<?php
$redis = new Redis();
$redis->connect('redis', 6379);

var_dump($redis->ping());

$memcached = new Memcached();
$memcached->addServer('memcaced', 11211);

var_dump($memcached->getVersion());

try {
    $cncStr = 'mysql:host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'];
    $dbh = new \PDO($cncStr, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
