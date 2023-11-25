<?php
declare(strict_types=1);
//echo '<pre>';print_r($_SERVER);echo '</pre>';

// Create a new instance of Memcached
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
$memcached->set('my_key', 'My Value Memcached hostname: ' . $_SERVER['HOSTNAME']);
$value = $memcached->get('my_key');
$memcached->delete('my_key');
$memcached->quit();

echo $value;
