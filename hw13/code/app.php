<?php

declare(strict_types=1);

use Gkarman\Datamaper\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    echo $app->run();
}
catch (Exception $e) {
    echo $e->getMessage();
}
