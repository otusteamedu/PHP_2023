<?php
declare(strict_types=1);

require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ .'/../src/app.php';

use Elena\Hw12\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    return( "400 Bad Request. ".$e->getMessage());
}



