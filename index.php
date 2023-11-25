<?php

declare(strict_types=1);

include_once __DIR__ . '/vendor/autoload.php';

use DimAl\Homework5\Application\App;

$app = new App();
//$app->run();
$app->checkEmailsFromFile(__DIR__ . '/testemails.txt');

