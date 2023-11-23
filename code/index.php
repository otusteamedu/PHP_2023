<?php

$host = 'db';

$user = 'db_user';

$pass = '123123';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL server successfully!";
}

echo "</br></br>";

$redis = new Redis();
$redis->connect('redis', 6379);
echo "Connection to Redis server successfully</br>";
echo "Server is running: " . $redis->ping();

echo "</br></br>";

$mc = new Memcached();

$mc->addServer("memcached", 11211);

echo "Connection to Memcached successfully</br>";

$mc->set("key", "Memcached");

$mc->set("status", "ok");

echo $mc->get("key") . " is " . $mc->get("status");

phpinfo();
