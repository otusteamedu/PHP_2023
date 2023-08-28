<?php

$redis = new Redis();
$redis->connect('redis', 6379);

echo "check redis:<br>";
var_dump($redis->ping());
echo "<br>";

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

echo "check memcache:<br>";
var_dump($memcached->getVersion());
echo "<br>";

try {
    echo "check mysql:<br>";
    $dsn = 'mysql:host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'];
    $dbh = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
