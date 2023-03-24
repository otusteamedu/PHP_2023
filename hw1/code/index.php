<?php

//require_once 'vendor/autoload.php';
//require_once 'vendor/predis/predis/autoload.php';

//Predis\Autoloader::register();

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

echo "Новая строка";

$link = mysqli_connect('mysql', 'root', 'root');
if (!$link) {
    die('Ошибка соединения: ' . mysqli_error());
}
echo 'Успешно соединились';
mysqli_close($link);

$redis = new \Redis();
/*
$client = new Predis\Client('tcp://redis:6379');
$client->set('foo', 'bar');
$value = $client->get('foo');
echo $value;*/
phpinfo();