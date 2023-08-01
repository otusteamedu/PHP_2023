<?php

declare(strict_types=1);

use Art\Code\App;

require_once __DIR__ . '/vendor/autoload.php';

try {
    (new App('redis'))->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
