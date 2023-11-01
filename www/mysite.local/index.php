<?php

echo "<h3>HELLO WORLD!</h3>";

echo "<h2>PHP: " . phpversion() . "</h2>";

$redis = new Redis();
$redis->connect(getenv('REDIS_HOST'));
echo "<h2>REDIS: " . $redis->info('server')['redis_version'] . "</h2>";

$mysqli = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
$q = $mysqli->query("SELECT VERSION()");
$mysql_ver = mysqli_fetch_all($q)[0][0];
echo "<h2>MYSQL: $mysql_ver</h2>";

$memcached = new Memcached();
$memcached->addServer(getenv('MEMCACHED_HOST'), 11211);

$ver = is_array($memcached->getVersion()) ? array_values($memcached->getVersion())[0] : '-';
echo "<h2>MEMCACHED: $ver</h2>";
