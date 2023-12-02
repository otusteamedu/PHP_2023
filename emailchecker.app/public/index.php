<?php

require '../vendor/autoload.php';

use Dshevchenko\Emailchecker\App;

try {
    $app = new App();
    $app->run();
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage();
}
