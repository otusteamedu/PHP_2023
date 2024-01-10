<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\App\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
