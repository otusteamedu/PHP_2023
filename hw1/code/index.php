<?php

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

// Параметры подключения к базе данных
$hostname = 'mysql';
$username = 'user';
$password = 'pass';
$database = 'app';

// Создание подключения
$connection = new mysqli($hostname, $username, $password);
// Проверка подключения
if ($connection->connect_error) {
    echo "Ошибка подключения: " . $connection->connect_error;
} else {
    echo "Подключение к базе данных MySQL успешно установлено!";
}

define('MEMCACHED_HOST', 'memcached');
define('MEMCACHED_PORT', '11211');
$memcache = new Memcached;
$cacheAvailable = $memcache->addServer(MEMCACHED_HOST, MEMCACHED_PORT);

if ($cacheAvailable) {
    echo "<br>Memcached подключен!";
} else {
    echo "<br>Ошибка Memcached";
}

$redis = new Redis();
$redis->connect('redis');
$redisPing = $redis->ping();

if ($redisPing) {
    echo "<br>Redis подключен!";
} else {
    echo "<br>Ошибка Redis";
}