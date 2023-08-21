<?php

session_start();


$memcached = new \Memcached();
$isAdded = $memcached->addServer('memcache01', 11211, 33);
echo $isAdded ? '+' : '-';
echo '<br>';
$isAdded = $memcached->addServer('memcache02', 11211, 33);
echo $isAdded ? '+' : '-';
echo '<br>';

$myKey = 'uuid-key';
$memcached->set($myKey, 'memcached-value', 10);

$memcachedValue = $memcached->get($myKey);
echo 'memcachedValue:';
var_dump($memcachedValue);
echo '<br>';

echo 'id::';
echo 'id:' . session_id();
echo '<br>';


echo 'Привет, Otus!!!';
echo '<br>';

echo 'Time: ' . date('Y-m-d H:i:s');
echo '<br>';
echo '<br>';

$hostName = $_SERVER['HOSTNAME'];
echo 'Запрос обработал контейнер:: ' . $hostName;
echo '<br>';

$containers = $_SESSION['hist'] ?? [];
$containers[$hostName] = isset($containers[$hostName]) ? $containers[$hostName] + 1 : 1;
$_SESSION['hist'] = $containers;

echo 'PHP_Version: ' . PHP_VERSION;
echo '<br>';

//
$memcache = new Memcache();
$memcache->connect('memcache01', 11211);
$memcache->connect('memcache02', 11211);

$version = $memcache->getVersion();
echo 'Memcache version: ' . $version;
echo '<br>';
//
$key = 'memcache->getVersion();';
$memcache->set($key, 'my-val', MEMCACHE_COMPRESSED, 10);
//waiting more than 10 sec
//sleep(20);
//
$key = $memcache->get($key);
echo 'value-by-key:';
var_dump($key);
echo '<br>';
//echo $key ? '+' : '-';

var_dump($_SESSION);
