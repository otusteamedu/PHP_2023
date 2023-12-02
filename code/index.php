<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Daniel\Socketchat\App;

try {
    $app = new App();
    $app->run( $argv[1] ?? null);
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
