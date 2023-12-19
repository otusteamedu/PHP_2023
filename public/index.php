<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

//dl('C:\php_pdo_pgsql.dll');

/** @var string название базы данных */
$dbname = 'postgres';
/** @var string имя пользователя */
$username = 'admin';
/** @var string пароль пользователя */
$password = 'root';
/** @var string адрес базы данных */
$host = '127.0.0.1';
/** @var int порт доступа к базе данных */
$port = 5432;
/** @var array дополнительные опции соединения с базой данных */
$options = [];

/** @var string формируем dsn для подключения */
$dsn = "pgsql:host=".$host.";port=".$port.";dbname=".$dbname;
/** @var PDO подключение к базе данных */
$db = new PDO($dsn,$username,$password, $options);

$dataMapper = new \App\DataMapper\UserDataMapper($db);

var_dump($dataMapper->findAll());