<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

try {
    (new \Art\Php2023\Infrastructure\Http\AppController())->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
