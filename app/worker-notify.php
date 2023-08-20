<?php

declare(strict_types=1);

use Root\App\Settings;
use Root\App\WorkerNotify;

require __DIR__ . '/vendor/autoload.php';

try {
    $settings = new Settings('./config.ini');

    $worker = new WorkerNotify($settings);
    $worker->listen();
} catch (Exception $e) {
    echo 'Fatal error: ' . $e->getMessage();
}
