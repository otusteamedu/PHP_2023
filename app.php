<?php

declare(strict_types=1);

use App\DataMapper\Movie\MovieMapper;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ .'/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$db = require __DIR__ . '/src/Config/db.php';
$pdo = new PDO($db['dsn'], $db['username'], $db['password'], $db['options']);
$mapper = new MovieMapper($pdo);

try {
    print_r($mapper->findAll()->getMovies());
} catch (Throwable $e) {
    echo $e->getMessage();
}

