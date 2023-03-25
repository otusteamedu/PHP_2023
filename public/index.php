<?php

use Pzagainov\Balancer\App;

require_once(__DIR__ . '/../vendor/autoload.php');

try {
    $app = new App();
    echo $app->run();
} catch (\Exception $e) {
    http_response_code($e->getCode());
    echo $e->getMessage();
}
