<?php
declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

session_start();

define("PHP_BR",'</br>');

echo "Container name: {$_SERVER['HOSTNAME']}".PHP_BR;
echo 'Ip: '.$_SERVER['SERVER_ADDR'].PHP_BR;
echo 'Open Session:' .( (isset($_SESSION['counter'])) ? ++$_SESSION['counter'] : $_SESSION['counter'] = 1) .PHP_BR;

// from docs: https://github.com/phpredis/phpredis#class-redis
$redis = new Redis();
echo ( $redis->connect('redis') ? 'Redis its work!' : 'Failed connect to redis').PHP_BR;

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
$memcached->set('session',999);
echo ( $memcached->get('session') === 999 ? 'Memcached its work!' : 'Failed connect to memcached').PHP_BR;
$pdo = new \PDO("mysql:dbname={$_SERVER['MYAPP_MYSQL_DATABASE']};host={$_SERVER['MYAPP_MYSQL_HOST']}",$_SERVER['MYAPP_MYSQL_USER'],$_SERVER['MYAPP_MYSQL_PASSWORD']);

echo (!$pdo)? 'Failed connect to mysql': 'MySQL its work!'.PHP_BR;