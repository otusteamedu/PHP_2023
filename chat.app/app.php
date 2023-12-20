<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Dshevchenko\Brownchat\App;
use Dshevchenko\Brownchat\Console;

try {
    $app = new App();
    $app->run($argv);
} catch (\Exception $e) {
    Console::write($e->getMessage());
}
