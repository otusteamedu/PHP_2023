<?php
require_once 'vendor/autoload.php';
try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    echo "Редис работает<br/>";
} catch (Exception $e) {
    echo $e->getMessage() . "<br/>";
}

try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $memcached->add('message', 'Memcached работает');
    echo $memcached->get('message');
} catch (Exception $e) {
    throw new Exception('Memcached error: ' . $e->getMessage());
}