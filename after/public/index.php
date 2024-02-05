<?php

declare(strict_types=1);

define('APP_PATH', dirname(__DIR__));

use App\App;

require_once APP_PATH . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
