<?php

// Test Redis
$redis = new Redis();
$redis->connect('redis');
echo "REDIS: " . $redis->info('server')['redis_version'] . "</br></br>";

// Test Memcache
$memcache = new Memcache();
$memcache->connect('memcached', 11211);
echo "Memcache: " . $memcache->getVersion() . "</br></br>";

// Test MySQL (Docker)
$mysqli_connection = new MySQLi('db', 'docker', 'secret', 'test');

if ($mysqli_connection->connect_error) {
    echo "MySQL Not connected, error: " . $mysqli_connection->connect_error;
}
else {
    echo "MySQL Connected to Docker container.<br><br>";
}

// Test MySQL (Homestead)
$mysqli_homestead_connection = new MySQLi('192.168.56.56', 'homestead', 'secret', 'homestead', 3306);

if ($mysqli_homestead_connection->connect_error) {
    echo "MySQL Connected to Homestead";
} 
else {
    echo "MySQL Not connected to Homestead, error: " . $mysqli_homestead_connection->connect_error;
}

phpinfo();
