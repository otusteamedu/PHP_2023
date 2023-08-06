<?php
phpinfo();

$redis = new Redis();

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

try {
    $redis->connect('redis', 6379);
} catch (RedisException $e) {
    echo $e->getMessage();
    exit;
}

if ( !$redis->exists('testkey')) {
    $redis->set('testkey', 'Test_messages'.uniqid('_otus_hw_redis_'), 300);
}

$redisValue = $redis->get('testkey');

if ( !$memcached->get('testkey')) {
    $memcached->set('testkey', 'Test_messages'.uniqid('_otus_hw_memcached_'), 300);
}

$memcachedValue = $memcached->get('testkey');

$result = "Значение из Redis: {$redisValue}" . PHP_EOL . "Значение из Memcached: {$memcachedValue}";

echo $result;

