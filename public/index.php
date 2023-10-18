<?php

declare(strict_types=1);

use src\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/App.php';

$app = new App();

$app->run();
