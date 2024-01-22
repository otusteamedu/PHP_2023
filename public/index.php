<?php

declare(strict_types=1);

define('APP_PATH', dirname(__DIR__));

use App\App;

require_once APP_PATH . '/vendor/autoload.php';

try {
    (new App())->run();
} catch (Exception $exception) {
}
