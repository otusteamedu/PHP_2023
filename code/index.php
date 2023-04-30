<?php

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

echo "Новая строка 2";

phpinfo();
$host = 'db';
$db   = 'otus';
$user = 'otus';
$pass = 'test';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

var_dump($pdo);exit;

