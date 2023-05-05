HELLO WORLD<?php
$redis = new Redis();
try {
    $redis->connect('redis', 6379);//'redis:6379' не делай так=)
    $redis->auth($_ENV['REDIS_PASSWORD']);
    $redis->publish(
        'redis',
        json_encode([
            'test' => 'success'
        ])
    );
    $redis->close();
    echo "<span style = 'color:green'>REDIS: OK</span><br>";
} catch (Exception $e) {
    $error = $e->getMessage();
    echo "<span style = 'color:red'>{$error}</span><br>";
}
try {
    $memcached = new Memcached();
    $memcached->addServer("memcached", 11211);
    $response = $memcached->get("successful");
    if (! $response) {
        $memcached->set("successful", "Memcached: OK");
        $response = $memcached->get("successful");
    }
    echo "<span style = 'color:green'>{$response}</span><br>";
} catch (Exception $e) {
    $error = $e->getMessage();
    echo "<span style = 'color:red'>{$error}</span><br>";
}
try {
    $pdo = new PDO(
        'mysql:host=' . $_ENV['MYSQL_HOST']
            . ';dbname=' . $_ENV['MYSQL_DATABASE'],
        $_ENV['MYSQL_USER'],
        $_ENV['MYSQL_PASSWORD']
    );
    echo "<span style = 'color:green'>MariaDB: OK</span><br>";
} catch (PDOException $e) {
    $error = $e->getMessage();
    echo "<span style = 'color:red'>{$error}</span><br>";
}
phpinfo();
