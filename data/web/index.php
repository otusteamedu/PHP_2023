<?php

// Test Redis
$redis = new Redis();
$redis->connect('redis');
echo "REDIS: " . $redis->info('server')['redis_version'] . "</br></br>";

// Test Memcache
$memcache = new Memcache;
$memcache->connect('memcached',11211);
echo "Memcache: " . $memcache->getVersion() . "</br></br>";

// Test MySQL
 $mysqli_connection = new MySQLi('db', 'my_user', 'my_password', 'my_database');
 if ($mysqli_connection->connect_error) {
    echo "MySQL Not connected, error: " . $mysqli_connection->connect_error;
 }
 else {
    echo "MySQL Connected.";
 }

 phpinfo();

