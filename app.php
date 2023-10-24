<?php

declare(strict_types=1);

use DKhalikov\Hw5\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    throw new \Exception($e->getMessage());
}