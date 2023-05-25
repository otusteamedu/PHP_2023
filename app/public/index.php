<?php

use YakovGulyuta\Hw15\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'Error ' . $e->getMessage();
    exit(1);
}
