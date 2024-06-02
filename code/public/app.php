<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Propan13\App\Application;

try {
    $app = new Application();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}


