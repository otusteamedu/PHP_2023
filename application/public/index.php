<?php

// from docs: https://github.com/phpredis/phpredis#class-redis
$redis = new Redis();

if ($redis->connect('redis')) {
    echo 'Connected to redis<br />';
} else {
    echo 'Cannot connect to redis<br />';
}

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

$memcached->set('test', 100);

if ($memcached->get('test') === 100) {
    echo 'Memcached connected<br />';
} else {
    echo 'Cannot connect to memcached<br />';
}

$mysqli = new mysqli(
    "mysql:3306",
    $_SERVER['MYAPP_MYSQL_USER'],
    $_SERVER['MYAPP_MYSQL_PASSWORD'],
    $_SERVER['MYAPP_MYSQL_DATABASE']
);

if ($mysqli->connect_error) {
    echo 'Cannot connect to mysql<br />';
} else {
    echo 'MySQL connected<br />';
}
