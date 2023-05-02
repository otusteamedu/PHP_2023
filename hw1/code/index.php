<?php

echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";
echo "Что-то еще Тест Тест TEST <br>";
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
    echo "<span style = 'color:green'>Successful connection to REDIS</span><br>";
} catch (Exception $e) {
    $error = $e->getMessage();
    echo "<span style = 'color:red'>{$error}</span><br>";
}
try {
    $memcached = new Memcached();
    $memcached->addServer("memcached", 11211);
    $response = $memcached->get("successful");
    if (! $response) {
        $memcached->set("successful", "Successful connection to Memcached!");
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
    foreach ($pdo->query('show tables;') as $row) {
        print_r($row);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
phpinfo();
