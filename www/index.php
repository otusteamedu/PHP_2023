<?php

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

// Проверяем redis
//$redis = new Redis();
//$redis->connect('redis', 6379);
//
//echo "Проверяем redis:<br>";
//var_dump($redis->ping());
//echo "<br><br>";
//
//$redis->close();

// Проверяем memcached
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

echo "Проверяем memcached:<br>";
var_dump($memcached->getVersion());
echo "<br><br>";

// Проверяем mysql
try {
    echo "Проверяем mysql:<br>";
    // $dsn = 'mysql:host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'];
    $dsn = 'mysql:host=' . 'application.local' . ';dbname=' . 'test_db';
    // $dbh = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
    $dbh = new PDO($dsn, "user", "123456");
} catch (PDOException $exception) {
    echo $exception->getMessage();
}

echo "<br><br>";
