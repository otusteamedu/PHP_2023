<?php
declare(strict_types=1);

session_start();

echo "Host name: {$_SERVER['HOSTNAME']}<br />";

if (gethostbyname('web') === $_SERVER['SERVER_ADDR']) {
    echo "Webserver 'web' got this request<br />";
} else if (gethostbyname('web2') === $_SERVER['SERVER_ADDR']) {
    echo "Webserver 'web2' got this request<br />";
} else {
    echo "I don't know the name of the current sever";
}

echo 'Session counter: ' . (array_key_exists('counter', $_SESSION) ? ++$_SESSION['counter'] : $_SESSION['counter'] = 1) . '<br />';

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