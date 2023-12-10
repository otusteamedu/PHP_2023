<?php

use Cases\Php2023\Application\Command\App;

require __DIR__.'/../vendor/autoload.php';

$app = new App();

try {
    $app->run($argv);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
