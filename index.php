<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Dimal\Hw6\Application\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    var_dump($e->getMessage());
}
