<?php

declare(strict_types=1);

use AYamaliev\hw13\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new App())->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
