<?php

declare(strict_types=1);

use App\DataMapper\Movie\MovieMapper;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$pdo = new PDO(
    "pgsql:host={$_ENV['POSTGRES_HOST']};port={$_ENV['POSTGRES_PORT']};dbname={$_ENV['POSTGRES_DB']}",
    $_ENV['POSTGRES_USER'],
    $_ENV['POSTGRES_PASSWORD'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
);
$mapper = new MovieMapper($pdo);

try {
    $movie = $mapper->getById(1);
    $movie->setName('test');
    $mapper->update($movie, ['name' => $movie->getName()]);
} catch (Throwable $e) {
    echo $e->getMessage();
}
