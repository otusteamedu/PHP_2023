<?php

$redis = new Redis();
$redis->connect('redis', 6379);

var_dump($redis->ping());

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

var_dump($memcached->getVersion());
