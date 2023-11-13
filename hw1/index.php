<?php

declare(strict_types=1);

require "vendor/autoload.php";

$env = Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

// Db
$dbHost = $env['DB_HOST'];
$dbName = $env['DB_DATABASE'];
$dbUser = $env['DB_USERNAME'];
$dbPassword = $env['DB_PASSWORD'];

try {
    $dbConnectionString = "pgsql:host={$dbHost};port=5432;dbname={$dbName};user={$dbUser};password={$dbPassword}";
    $dbConnection = new PDO($dbConnectionString);
    echo "<br>Connected to Postgres.";
} catch (PDOException $e) {
    echo "<br> " . $e->getMessage();
}

// Redis
$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => $env['REDIS_HOST'],
    'port'   => $env['REDIS_PORT'],
]);

$redis->set("first", "second");
echo "<br>Redis value: " . $redis->get("first");

// Memcached
$memcached = new Memcached();
$memcached->addServer($env['MEMCACHED_HOST'], intval($env['MEMCACHED_PORT'])) or print("<br>Could not connect");
$memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
$memcached->set("test", "test memcache") or print("<br> Key in Memcached can't be created");
echo "<br>Memcached value: " . $memcached->get("test");
