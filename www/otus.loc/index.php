<?php
// Подключаем Redis
$redis = new Redis();
$redis->connect('redis');

// Проверяем соединение с Redis
if ($redis->ping()) {
    echo "Redis соединение успешно установлено!<br>";
} else {
    echo "Не удалось установить соединение с Redis.<br>";
}

// Подключаем Memcached
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

// Проверяем соединение с Memcached
if ($memcached->getVersion()) {
    echo "Memcached соединение успешно установлено!<br>";
} else {
    echo "Не удалось установить соединение с Memcached.<br>";
}

// Подключаемся к MySQL
$mysqli = new mysqli('mysql', 'root', '123456', 'db');

// Проверяем соединение с MySQL
if ($mysqli->connect_errno) {
    echo "Не удалось установить соединение с MySQL: " . $mysqli->connect_error . "<br>";
} else {
    echo "MySQL соединение успешно установлено!<br>";
    $mysqli->close();
}