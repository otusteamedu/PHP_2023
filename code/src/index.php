<?php

// echo phpinfo();

require '../vendor/autoload.php';

try {
    $pdo = new PDO('pgsql:host=pgsql;port=5432;dbname=dbname', 'dbuser', 'dbpwd');

    $redis = new Predis\Client('tcp://redis:6379');

    $memcached = new Memcached();
    $memcached->addServer('memcache', '11211');
    $memcached->set('key', 'value');

    if ($pdo) {
        echo "Connected to the database successfully!";
    }
    if ($redis->ping()) {
        echo "<br> Redis Ok";
    }
} catch (PDOException $e) {
    die($e->getMessage());
} finally {
    if ($pdo) {
        $pdo = null;
    }
}
