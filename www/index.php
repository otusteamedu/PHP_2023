<?php

declare(strict_types=1);

use Chernomordov\App\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    echo $app->run();
} catch (Exception $e) {
    throw new \Exception($e->getMessage());
}
