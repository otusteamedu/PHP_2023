<?php

use Yakovgulyuta\Hw13\App;

require_once('../vendor/autoload.php');


try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
    exit(1);
}
