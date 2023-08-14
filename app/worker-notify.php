<?php

declare(strict_types=1);

use Root\App\WorkerNotify;

require __DIR__ . '/vendor/autoload.php';

try {
    $worker = new WorkerNotify();
    $worker->listen();
} catch (Exception $e) {
    echo 'Fatal error: ' . $e->getMessage();
}
