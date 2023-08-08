<?php

declare(strict_types=1);

require_once ('vendor/autoload.php');

use DEsaulenko\Hw12\App\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    dump($e);
}
