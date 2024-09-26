<?php

declare(strict_types=1);

use Ddushinov\OtusDockerHw1\Hello;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

Hello::sayHi();

$arParams = [
    'host' => 'mysql',
    'dbname' => 'otus',
    'username' => 'ddushinov',
    'password' => '222222!',
];

try {
    $dbh = new PDO(
        'mysql:host=' . $arParams['host']
        . ';dbname=' . $arParams['dbname']
        . ';charset=utf8;',
        $arParams['username'],
        $arParams['password'],
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_EMULATE_PREPARES => false
        )
    );

    $stm = $dbh->query('SELECT VERSION() as version', PDO::FETCH_OBJ);
    if ($rs = $stm->fetch()) {
        echo 'Current version MySql ' . $rs->version . '<br>';
    }

} catch (PDOException | Exception $e) {
    die($e->getMessage());
}
$dbh = null;
$stm = null;
/**/


$redis = new Redis();
$redis->connect('redis', 6379);
//$redis->auth('password');

try {
    if ($redis->ping()) {
        echo 'PONG<br>';
    }
} catch (RedisException $e) {
    die($e->getMessage());
}
/**/


$memcached = new Memcached();
$isMemcachedAvailable = $memcached->addServer('memcached', 11211);

if ($memcached->set('foo', 100, 3600)) {
    echo 'Исходные данные успешно кэшированы ' . $memcached->get('foo') . '<br>';
} else {
    echo 'Данные уже существуют：' . var_dump($memcached->get('foo')) . '<br>';
}
/**/
