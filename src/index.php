<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\Hw11\DBConfig;

$dbConectionParams = [
    'host' => $_ENV["MYSQL_HOST"],
    'port' => (int)$_ENV["MYSQL_PORT"],
    'database' => $_ENV["MYSQL_DATABASE"],
    'user' => $_ENV["MYSQL_USER"],
    'password' => $_ENV["MYSQL_PASSWORD"]
];

echo '<hr>Mysql:<br>';

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $DB = new mysqli(...DBConfig::getNormalizedParams($dbConectionParams));
    $result = $DB->query('SHOW DATABASES');
    $arDatabases = [];

    while ($row = $result->fetch_assoc()) {
        $arDatabases[] = $row;
    }

    echo 'Existing databases - ';
    echo '<pre>';
    var_export($arDatabases);
    echo '</pre>';
} catch (Throwable $e) {
    echo 'Error: ' . $e->getMessage();
}

echo '<hr>Redis:<br>';

try {
    $redis = new Redis();
    $redis->connect($_ENV['REDIS_HOST'], (int)$_ENV['REDIS_PORT']);

    if ($redis->ping()) {
        echo "Server is running";
    }
} catch (RedisException $e) {
    echo 'Error: ' . $e->getMessage();
}

echo '<hr>Memcached:<br>';

try {
    $memcached = new Memcached();
    $memcached->addServer($_ENV['MEMCACHED_HOST'], (int)$_ENV['MEMCACHED_PORT']);

    echo "Memcached version is " . implode(', ', $memcached->getVersion());
} catch (RedisException $e) {
    echo 'Error: ' . $e->getMessage();
}
