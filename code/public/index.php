<?php

declare(strict_types=1);

require '../vendor/autoload.php';

try {
    (new \Art\Code\Infrastructure\App())->run();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

