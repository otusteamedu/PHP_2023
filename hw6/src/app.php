<?php

require_once('./vendor/autoload.php');

use AShashkov\ConsoleSocketChat\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
