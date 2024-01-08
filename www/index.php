<?php

declare(strict_types=1);

use Chernomordov\App\DataMapper\MoviesDataMapper;

require __DIR__ . '/vendor/autoload.php';

$pdo = new PDO("mysql:host=db;dbname=sitemanager", "sitemanager", "123");
$moviesDataMapper = new MoviesDataMapper($pdo);
$movie1 = $moviesDataMapper->findById(1);
echo "Movie 1: {$movie1->getName()} ({$movie1->getProductionYear()})\n";

$newMovieData = [
    'name' => 'Inception',
    'duration' => '02:28:00',
    'production_year' => '2010',
];

$newMovie = $moviesDataMapper->insert($newMovieData);

echo "New Movie ID: {$newMovie->getId()}\n";

$existingMovie = $moviesDataMapper->findById(3);
$updatedData = [
    'name' => 'The Wolf of Wall Street',
    'duration' => '03:15:00',
];

$moviesDataMapper->update($existingMovie, $updatedData);
echo "Updated Movie: {$existingMovie->getName()} ({$existingMovie->getDuration()})\n";

$movieToDelete = $moviesDataMapper->findById(4);
$moviesDataMapper->delete($movieToDelete);
echo "Movie 1 deleted.\n";
