<?php

declare(strict_types=1);

use app\App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/App.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
