<?php

include __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

use VKorabelnikov\Hw13\DataMapper\Film;
use VKorabelnikov\Hw13\DataMapper\FilmColumnsMapper;


$pdo = new \PDO("pgsql:host=hw13-postgres;port=5432;dbname=test;","test", "test");

$filmsMapper = new FilmColumnsMapper($pdo);


// $filmsMapper->insert(
//     [
//         'name' => "film1",
//         'duration' => "03:12",
//         'cost' => "25.99"
//     ]
// );

// $filmsMapper->insert(
//     [
//         'name' => "film2",
//         'duration' => "08:21",
//         'cost' => "28.99"
//     ]
// );

// $filmsMapper->update(
//     new Film(
//         1,
//         "ff",
//         "00:01",
//         0.01
//     )
// );

// var_dump(
//     $filmsMapper->findById(1)
// );

// $filmsMapper->delete(
//     new Film(
//             1,
//             "ff",
//             "00:01",
//             0.01
//         )
//     );



$allFilms = $filmsMapper->getAll();

var_dump($allFilms->get(0));

// $allFilms->set(2, new Film(1, "film3", "1:22", 2.1));
// var_dump($allFilms->get(2));

// $allFilms->unset(2);
// var_dump($allFilms->get(2));



