<?php

use IilyukDmitryi\App;

require_once('vendor/autoload.php');

try {
    $app = new App\App();
    $app->run();
} catch (Exception $e) {
    echo 'Exception ' . $e->getMessage();
}
