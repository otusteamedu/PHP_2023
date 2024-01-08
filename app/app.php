<?php

use Builov\Chat\App;

require_once('vendor/autoload.php');

try {
    $app = new App();
    $app->run();
}
catch(Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
