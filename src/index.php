<?php

function customPrint(array $array): void
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

$redis = new Redis();
$redis->connect('redis', 6379);
print_r('Redis работает? ' . $redis->ping());

echo '<hr>';

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
print_r('Версия memcached:');
customPrint($memcached->getVersion());

echo '<hr>';

$db = $_ENV['MYSQL_DATABASE'];
$user = 'root';
$pass = $_ENV['MYSQL_ROOT_PASSWORD'];

$dbh = new PDO("mysql:host=mysql;dbname={$db}", 'root', $pass);
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

print_r('Список БД:');
customPrint($dbh->query('SHOW DATABASES')->fetchAll());

echo '<hr>';

print_r('Версия composer:');
echo '<br>' . `composer --version`;
