<?php

declare(strict_types=1);

use Vp\App\App;
use Vp\App\Services\CommandProcessor;

require_once('vendor/autoload.php');
require_once('bootstrap.php');

try {
    $app = new App(new CommandProcessor());
    $app->run($_SERVER['argv']);
} catch (Exception $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . PHP_EOL);
}
