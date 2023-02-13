<?php

require_once __DIR__ . '/../vendor/autoload.php';

$redis = new \Redis();
$redis->connect('redis');
$redis->set('item', 'Hi, redis!');
echo $redis->get('item') . '<br>';

$memcache = new Memcached();
$memcache->addServer('memcache', 11211);
$memcache->set('mem', 'Hi, memcache!');
echo $memcache->get('mem') . '<br>';

try {
    $dbh = new PDO(
        'mysql:host=db;port=3306;dbname=' . getenv('MYSQL_DATABASE'),
        'root',
        getenv('MYSQL_ROOT_PASSWORD')
    );
    echo '<pre>';
    foreach ($dbh->query('SELECT user, host FROM mysql.user') as $row) {
        print_r($row);
    }
    echo '</pre>';
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$printer = new PrintCat\PrintCat();
$printer->printRandom();
