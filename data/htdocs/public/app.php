<?php

error_reporting(E_ERROR);
ini_set('display_errors', true);
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

try {
    $app = new \Sva\App\App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
