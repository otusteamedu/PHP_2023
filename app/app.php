<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Chat\App;

try {
    set_time_limit(0);
    ob_implicit_flush();

    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
