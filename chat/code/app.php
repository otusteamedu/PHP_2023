<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

use IilyukDmitryi\App;

require_once('vendor/autoload.php');

try {
    $configProvider = new App\Config\FileIni();
    $app = new App\App($configProvider);
    $app->run();
} catch (Exception $e) {
    echo 'Exception '.$e->getMessage();
}

