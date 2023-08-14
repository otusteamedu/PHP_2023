<?php

declare(strict_types=1);

use Root\App\WorkerExec;

require __DIR__ . '/vendor/autoload.php';

try {
    $worker = new WorkerExec();
    $worker->listen();
} catch (Exception $e) {
    echo 'Fatal error: ' . $e->getMessage();
}
