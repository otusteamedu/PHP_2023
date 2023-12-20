<?php
echo "Hello Otus!!!!";

echo "<br>";
$redis = new Redis();
$redis->connect('redis', 6379);
$redis->set('key', 'value');
$value = $redis->get('key');
echo "Redis:" . $value;

echo "<br>";
$memcached = new Memcached();
$memcached->addServer('memcached', 11211); // Используем имя службы Docker Compose "memcached"
$memcached->set('key', 'value', 60);
$value = $memcached->get('key');
echo "Memcached:" . $value;
