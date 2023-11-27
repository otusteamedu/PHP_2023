<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use DimAl\Homework5\Application\App;

$app = new App();
$app->run();
