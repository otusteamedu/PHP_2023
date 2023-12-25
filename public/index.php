<?php

declare(strict_types=1);

use App\DataMapper\FilmDataMapper;

require_once __DIR__ . '/../vendor/autoload.php';

$dbname = 'postgres';
$username = 'admin';
$password = 'root';
$host = '127.0.0.1';
$port = 5432;
$options = [];

$dsn = "pgsql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname;
$db = new PDO($dsn, $username, $password, $options);

$filmDataMapper = new FilmDataMapper($db);
$film = $filmDataMapper->insert([
    'name' => 'testName',
    'genre' => 'testGenre',
    'year_of_release' => 2024,
    'duration' => 120
]);

//Get Film from identity map
$filmDataMapper->findById(1);

//Get Film from DB
$filmFromDb = $filmDataMapper->refresh()->findById($film->getId());

//Update some fields of film
$filmDataMapper->update($filmFromDb, ['genre = ?' => 'newTestGenre', 'duration = ?' => 121]);
