<?php

declare(strict_types=1);

use Damir\OtusHw6\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    throw new \Exception($e->getMessage());
}