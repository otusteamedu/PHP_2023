<?php

require 'Models/Movie.php';
use Models\Movie;

$host = 'otus_db';
$db   = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);


/**
 * Паттерн Active Record
 */

$predator = new Movie($pdo);
$predator->insert([
    'name' => 'Хищник 2',
    'description' => 'uglier mf',
    'year' => 1992,
    'movie_type' => 2
]);

$terminator2 = Movie::getById($pdo, 3);
$terminator2->update([
    'description' => 'Арнольд Шварценеггер',
    'movie_type' => 2
]);

/**
 * Массовое получение информации
 */
$movies = Movie::getByWhere($pdo, '>', 'year', 1999);
echo '<pre>';
var_dump($movies);
echo '</pre>';


/**
 * Identity Map
 */
$vandammeMovie1 = Movie::getById($pdo, 2);
$vandammeMovie2 = Movie::getById($pdo, 2);
$vandammeMovie1->setName('Kickboxer');
echo '<pre>';
var_dump($vandammeMovie1->getName(), $vandammeMovie2->getName());
echo '</pre>';
