<?php
include(__DIR__ . '/vendor/autoload.php');

use Shabanov\Otusphp\App;

try {
    $app = new App();
    $app->run();
} catch(\Exception $e) {
    echo $e->getMessage();
}
