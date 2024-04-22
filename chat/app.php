<?php

use Anna\Chat\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    foreach ($app->run() as $message) {
        echo $message;
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
