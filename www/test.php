<?php
$memcached1 = new Memcached();
$memcached1->addServer('memcached-1', 11211);

$memcached2 = new Memcached();
$memcached2->addServer('memcached-2', 11211);




//$ver = is_array($memcached->getVersion()) ? array_values($memcached->getVersion())[0] : '-';
//echo "<h2>MEMCACHED: $ver</h2>";

//$memcached->set("key", time());

//var_dump($memcached->get("key"));

session_start();



var_dump($memcached1->getAllKeys());
var_dump($memcached2->getAllKeys());

//$_SESSION['test'] = time();

var_dump($_SESSION['test']);