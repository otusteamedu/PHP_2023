<?php

require_once __DIR__. "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable('/var/www/html');
$dotenv->load();

/**
 * DB connection
 */
$host     = $_ENV['DB_HOST'];
$userName = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$port     = $_ENV['DB_PORT'];
$dbName   = $_ENV['DB_DATABASE'];
try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbName", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Mysql connected successfully <br />';
} catch (PDOException $e) {
    echo "Mysql connection failed: " . $e->getMessage() . "<br />";
}


/**
 * Memcached connection
 */
$mc = new Memcached();
$mc->addServer($_ENV['MEMCACHED_HOST'], $_ENV['MEMCACHED_PORT']);

if ($addMC = $mc->add("test", "success")) {
    echo "Memcached connect successfully <br />";
    $mc->delete("test");
} else {
    echo "Memcached connection failed <br />";
}

/**
 * Redis connection
 */
$redis = new Redis();
try {
    $redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
    echo "Redis connect successfully <br />";
} catch (RedisException $e) {
    echo "Redis connection failed: " . $e->getMessage()."<br />";
}