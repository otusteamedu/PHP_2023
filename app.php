<?php

declare(strict_types=1);

use Santonov\Otus\Application;

require_once 'vendor/autoload.php';

try {
    $app = new Application();
    $app->run($argv);
} catch (Exception $exception) {
    echo $exception->getMessage();
}
