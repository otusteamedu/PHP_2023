<?php

declare(strict_types=1);

use Art\Code\Infrastructure\Http\AppController;

require_once __DIR__ . '/vendor/autoload.php';

try {
    (new AppController('redis'))->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
