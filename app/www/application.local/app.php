<?php

declare(strict_types=1);

use App\App;

require __DIR__ . "/../vendor/autoload.php";

try {
    $app = new App($argv, $argc);
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
