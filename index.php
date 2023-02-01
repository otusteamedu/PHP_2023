<?php

declare(strict_types=1);

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

// Postgres
$dbHost = $dotenv['DB_HOST'];
$dbName = $dotenv['POSTGRES_DB'];
$dbUser = $dotenv['POSTGRES_USER'];
$dbPassword = $dotenv['POSTGRES_PASSWORD'];

try {
    $dbConnectionString = "pgsql:host={$dbHost};port=5432;dbname={$dbName};user={$dbUser};password={$dbPassword}";
    $dbConnection = new PDO($dbConnectionString);
    echo "<br>Connected to Postgres.";
} catch (PDOException $e) {
    echo "<br> " . $e->getMessage();
}

// Redis
$redis = new Redis();
$redis->connect('otus-redis');
$redis->auth($dotenv['REDIS_PASSWORD']);
$redis->set("test", "Test");
echo "<br>Stored string in Redis: " . $redis->get("test");

// Memcached
$memcached = new Memcached();
$memcached->addServer('otus-memcached', 11211) or print("<br>Could not connect");
$memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
$memcached->setSaslAuthData($dotenv['MEMCACHED_USERNAME'], $dotenv['MEMCACHED_PASSWORD']);
$memcached->set("test-memcached", "12345") or print("<br> Key in Memcached can't be created");
echo "<br>Value from Memcached: " . $memcached->get("test-memcached");

phpinfo();
