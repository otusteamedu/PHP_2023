<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Twent\Hw13\App;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$app = new App();

$app->run();
