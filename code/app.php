<?php

use Radovinetch\Chat\App;

require 'vendor/autoload.php';

try {
    $app = new App();
    $app->run($argv);
} catch (Throwable $throwable) {
    throw $throwable;
}
