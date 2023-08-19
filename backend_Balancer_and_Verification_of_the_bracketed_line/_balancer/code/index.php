<?php

session_start();


$memcached = new \Memcached();
$isAdded = $memcached->addServer('memcache', 11211, 33);

$myKey = 'uuid-key';
$memcached->set($myKey, 'memcached-value', 10);
//session_start();
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
$memcache->connect('memcache', 11211);
////
$version = $memcache->getVersion();
echo 'Memcache version: ' . $version;
echo '<br>';
//
$key = 'memcache->getVersion();';
$memcache->set($key, 'my-val', MEMCACHE_COMPRESSED, 10);
////waiting more than 10 sec
////sleep(20);
//
$key = $memcache->get($key);
echo 'key:';
var_dump($key);
echo '<br>';
//echo $key ? '+' : '-';


//memcached_get('key', );

//$servers = explode(",", ini_get("session.save_path"));
//$c = count($servers);
//for ($i = 0; $i < $c; ++$i) {
//    $servers[$i] = explode(":", $servers[$i]);
//}
//var_dump($servers);

//$s = [['tcp://memcache:11211']];
//$memcached = new \Memcached();
//call_user_func_array([ $memcached, "addServers" ], $s);
//call_user_func_array([ $memcached, "addServers" ], $servers);
//$isAdded = $memcached->addServer('memcache', 11211, 33);
//echo '->Server';
//echo $isAdded ? '+' : '-';
//echo '<br>';
//print_r($memcached->getAllKeys());


//$memcached = new Memcached();
//$memcached->set('key','value',10);
////waiting more than 10 sec
////sleep(20);
//$data = $memcached->getAllKeys();
//var_dump($data); // key will still be listed
//$key = $memcached->get('key'); // will trigger the expiration
//var_dump($key);
//echo $key ? '+' : '-';

//var_dump($_SESSION);
//var_dump($_REQUEST);

//session_start();
//echo session_id();

//$memcache = new Memcache();

var_dump($_SESSION);
