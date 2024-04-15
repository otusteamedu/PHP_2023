<?php

declare(strict_types=1);

use Singurix\Chat\App;

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
});

try {
    $app = new App($argv);
} catch (Exception $e) {
    fputs(STDOUT, $e->getMessage() . "\n");
}
