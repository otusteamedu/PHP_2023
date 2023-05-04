<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    $redis = new \Predis\Client([
        'host' => 'otus-redis'
    ]);
    $redis->set('message', 'Redis is up!');

    echo $redis->get('message') . "<br>";
} catch (Exception $e) {
    throw new Exception('Redis error: ' . $e->getMessage());
}

try {
    $memcached = new Memcached();
    $memcached->addServer('otus-memcached', 11211, 42);

    $memcached->add('message', 'Memcached is up!');

    echo $memcached->get('message');
} catch (Exception $e) {
    throw new Exception('Memcached error: ' . $e->getMessage());
}
