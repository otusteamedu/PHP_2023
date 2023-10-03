<?php

declare(strict_types=1);

use Eevstifeev\Hw12\Application;

require 'vendor/autoload.php';

try {
    $app = new Application();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}