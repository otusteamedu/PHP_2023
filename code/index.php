<?php

require __DIR__ . '/vendor/autoload.php';

try {
    $redis = new Predis\Client('tcp://redis:6379');
} catch (Exception $e) {
    die($e->getMessage());
}

$redis->set('hello', "Hi Redis!");
$hello = $redis->get('hello');

echo $hello;
