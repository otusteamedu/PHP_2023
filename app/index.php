<?php

use Jasur\App\App;

require_once './vendor/autoload.php';

define('ROOT', dirname(__DIR__));

//\Pecee\SimpleRouter\SimpleRouter::start();

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
?>
