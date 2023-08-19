<?php

use DmitryEsaulenko\Hw15\App\App;
use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

try {
    Dotenv::createUnsafeImmutable(__DIR__)->load();
    $app = new App();
    $app->run();
} catch (Exception $e) {
    dump($e);
}
