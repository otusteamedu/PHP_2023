<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Timerkhanov\Elastic\App;

try {
    (new App($argv))->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
