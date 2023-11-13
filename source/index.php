<?php
    $configs = include('config.php');

    print_r("Homework #1! </br>");

    //DB connection
    $db = $configs['database'];

    $conn = new mysqli($db['host'], $db['user'], $db['password']);

    if ($conn->connect_error) {
        print_r("DB connection failed: " . $conn->connect_error);
    } else {
        print_r( 'DB connected successfully!');
    }

    print_r("</br>");

    //Redis connection
    $redisConf = $configs['redis'];

    $exception = null;

    $redis = new \Redis();
    try {
        $redis->connect($redisConf['host'], $redisConf['port']);
    } catch (\Exception $exception) {
        print_r("Redis connection failed: " . $e->getMessage());
    }

    if (!$exception) {
        print_r( 'Redis connected successfully!');
    }

    print_r("</br>");




