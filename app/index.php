<?php

require_once('./vendor/autoload.php');

$br = '</br>';

echo "Hello, OTUS $br";

// Test connect to redis
$redisClient = new Predis\Client([
    'host' => 'redis',
    'port' => $_ENV['REDIS_PORT'],
]);

$redisClient->set('foo', 'bar');

echo ($redisClient->get('foo')
    ? 'Connection to redis attempt succeeded.'
    : 'Connection to redis attempt failed.')
    . $br;

// Test connect to memcached
$memcached = new Memcached();

$memcached->addServer('memcached', $_ENV['MEMCACHED_PORT']);
$memcached->add('memcached_key', true);

echo ($memcached->get('memcached_key')
    ? 'Connection to memcached attempt succeeded.'
    : 'Connection to memcached attempt failed.')
    . $br;

// Test connect db
$db_handle = pg_connect(sprintf(
    'host=%s dbname=%s user=%s password=%s',
    'db',
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
));

echo $db_handle
    ? 'Connection to database ' . pg_dbname($db_handle) . ' attempt succeeded.'
    : 'Connection to database attempt failed.';

pg_close($db_handle);
