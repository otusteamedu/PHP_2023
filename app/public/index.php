<?php

declare(strict_types=1);

use Aporivaev\Hw09\App;
use Aporivaev\Hw09\AppException;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (AppException $e) {
    echo "App error. ", $e, "\n";
} catch (Exception | Error $e) {
    echo "Oops! Something went wrong.", $e->getMessage(), "\n";
}
