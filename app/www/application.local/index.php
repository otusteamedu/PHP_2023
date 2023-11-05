<?php

require "vendor/autoload.php";

try {
    $redis = new Predis\Client([
        'scheme' => 'tcp',
        'host' => 'redis',
        'port' => '6379',
    ]);
    $redis->set('app:redis:key', 'redis:value');
    echo "Redis: {$redis->get('app:redis:key')}";
} catch (Exception $e) {
    echo $e->getMessage();
}

echo '<br>';

try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $memcached->set('memcached_key', 'memcached_value');
    echo "Memcached: {$memcached->get('memcached_key')}";
} catch (Exception $e) {
    echo $e->getMessage();
}

echo '<br>';

try {
    $postgres = pg_connect("host=postgres port=5432 dbname=test user=test password=test");

    if (!$postgres) {
        throw new Error("Postgres: " . pg_last_error());
    }

    echo "Postgres: enabled";

    pg_close($postgres);
} catch (Exception $e) {
    echo $e->getMessage();
}