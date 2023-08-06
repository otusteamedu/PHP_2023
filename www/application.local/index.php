<?php

try {
    // Сходим в хомстид за бд
    $dbh = new PDO('mysql:host=192.168.56.56:3306;dbname=homestead', 'hw1', 'passwordpassword');
    echo "База данных работает<br/>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}


echo "Nginx работает<br/>";

$time = microtime(true);

try {
    $memcached = new Memcached();
    $memcached->addServer("memcached", 11211);
    $memcached->set("key", "value: $time");
    echo "Кэш работает " . $memcached->get("key") . "<br/>";
} catch (Exception $e) {
    echo $e->getMessage() . "<br/>";
}

try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    echo "Редис работает<br/>";
} catch (Exception $e) {
    echo $e->getMessage() . "<br/>";
}

echo "php работает<br/>";

phpinfo();
