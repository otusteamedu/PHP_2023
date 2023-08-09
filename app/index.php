<?php

require_once './vendor/autoload.php';

require_once 'config/routes.php';
require_once 'helpers.php';

define('ROOT', dirname(__DIR__));

$memcache = new Memcached();
$memcache->addServer('memcache', 11211);
$memcache->get('connection');


\Pecee\SimpleRouter\SimpleRouter::start();
?>
