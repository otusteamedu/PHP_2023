<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Application\AppRedisAndEvents;
use NdybnovHw03\CnfRead\ConfigStorage;


try {
    $configStorage = (new ConfigStorage())
        ->fromDotEnvFile([dirname(__DIR__), '.env']);

    (new AppRedisAndEvents($configStorage, $argv))
        ->run();
} catch (\Exception $exception) {
    echo $exception->getMessage();
    echo PHP_EOL;
}
