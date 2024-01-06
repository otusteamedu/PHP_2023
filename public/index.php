<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Application\AppQueue;
use App\Application\Log\Log;
use NdybnovHw03\CnfRead\ConfigStorage;


try {
    $configStorage = (new ConfigStorage())
        ->fromDotEnvFile([dirname(__DIR__), '.env']);

    (new AppQueue($configStorage, $argv ?? []))
        ->run();
} catch (\Exception $exception) {
    (new Log())->useRespond($exception->getMessage(), 501);
}
