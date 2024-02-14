<?php

declare(strict_types=1);

use App\Console;

require __DIR__ . '/vendor/autoload.php';

$console = new Console();
$console->run($argv);
