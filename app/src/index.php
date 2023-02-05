<?php
declare(strict_types=1);

$postgresql_user = 'user';
$postgresql_pass = 'password';
$postgresql_host = 'postgresql';
$postgresql_db = 'hw01';

$redis_host = 'redis';

$memcached_host = 'memcached';

function checkPostgresql(string $dsn, string $user, string $pass): bool
{
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stm = $pdo->query('SELECT * FROM example');
        $data = $stm->fetchAll();
        return count($data) > 0;
    } catch (PDOException $e) {
        return false;
    }
}

function checkRedis(string $host): bool
{
    try {
        $redis = new Redis();
        $redis->connect($host);
        return $redis->ping() === true;
    } catch (RedisException $e) {
        return false;
    }
}

function checkMemcached(string $host): bool
{
    $memcached = new Memcached();
    $memcached->addServer($host, 11211);

    $testIn = ['key' => 'key', 'value' => 'value'];
    if (!$memcached->set($testIn['key'], $testIn['value'])) {
        return false;
    }
    $testOut = $memcached->get($testIn['key']);
    return is_string($testOut) && $testOut === $testIn['value'];
}

echo 'postgresql: ', (checkPostgresql("pgsql:dbname={$postgresql_db} host={$postgresql_host}",
        $postgresql_user, $postgresql_pass) ? 'OK' : 'Error'), '<br>';
echo 'redis: ', (checkRedis($redis_host) ? 'OK' : 'Error'), '<br>';
echo 'memcached: ', (checkMemcached($memcached_host) ? 'OK' : 'Error'), '<br>';
