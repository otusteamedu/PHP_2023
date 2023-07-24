<?php

use Desaulenko\Hw11\App\App;

require_once 'vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    dump($e);
}
