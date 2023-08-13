<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Ro\Php2023\App;

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){
}


