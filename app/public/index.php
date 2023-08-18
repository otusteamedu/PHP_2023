<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    $app = new \Neunet\App\App();
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
    exit(1);
}
