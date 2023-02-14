<?php

try {
    $db = new PDO('mysql:host=mysql;dbname=docker', 'root', '12345');
} catch (PDOException $e) {
    print "Error! {$e->getMessage()}";
}
require __DIR__ . '/vendor/autoload.php';

try {
    $redis = new Predis\Client('tcp://redis:6379');
} catch (Exception $e) {
    die($e->getMessage());
}

$redis->set('hello', "Hi Redis!");
$hello = $redis->get('hello');

echo $hello;
