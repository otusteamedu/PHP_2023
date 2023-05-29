<?php

declare(strict_types=1);

use Art\Php2023\App;

require_once __DIR__ . '/vendor/autoload.php';

try {
    (new App())->run();
} catch (\Exception $e) {
    return $e->getMessage();
}
