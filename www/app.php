<?php

declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use Yalanskiy\Chat\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
