<?php
echo 'otus<br/><br/>';

$redis = new Redis();
$redis->connect('redis');

var_dump($redis->ping());

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

echo 'memcached version: ' . $memcached->getVersion()['memcached:11211'] . '<br/>';

try {
    $dsn = 'mysql:host=db;dbname=otus';
    $dbh = new \PDO($dsn, 'otus', '123');
    echo 'mysql connection<br/>';
} catch (PDOException $exception) {
    echo $exception->getMessage();
}