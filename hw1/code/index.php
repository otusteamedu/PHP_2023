<?php

// Создание подключения
$connection = new mysqli();
// Проверка подключения
if ($connection->connect_error) {
    echo "Ошибка подключения: " . $connection->connect_error;
} else {
    echo "Подключение к базе данных MySQL успешно установлено!";
}

$memcache = new Memcached();

$cacheAvailable = $memcache->addServer('memcached', '11211');

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
