<?php

echo "<h1>This is " . $_SERVER['HOSTNAME'] . "</h1>";
// Создание объекта Memcached
$memcached = new Memcached();

// Добавление серверов Memcached (адрес и порт)
$memcached->addServer("memcached", 11211);

$key = 'test_key';
$value = 'Hello, Memcached!';

// Запись данных
$memcached->set($key, $value, 3600);

// Чтение данных
$result = $memcached->get($key);

if ($result === $value) {
    echo sprintf('Memcached is working! Your value: %s<br>', $result);
} else {
    echo "Memcached is not working!";
}

phpinfo();
