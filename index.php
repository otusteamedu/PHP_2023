<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$ENV = Dotenv::createImmutable(__DIR__);
$ENV->load();

$app = new App\Main();
$app->start();
