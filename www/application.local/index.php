<?php

echo "Nginx работает<br/>";

$time = microtime(true);

try {
    $memcached = new Memcached();
    $memcached->addServer("memcached", 11211);
    $memcached->set("key", "value: $time");
    echo "Кэш работает " . $memcached->get("key") . "<br/>";
} catch (Exception $e) {
    echo $e->getMessage() . "<br/>";
}

try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    echo "Редис работает<br/>";
} catch (Exception $e) {
    echo $e->getMessage() . "<br/>";
}

echo "php работает<br/>";

phpinfo();
