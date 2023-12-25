<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\AppSearch;
use NdybnovHw03\CnfRead\ConfigStorage;


try {
    $configStorage = (new ConfigStorage())
        ->fromDotEnvFile([
            dirname(__DIR__),
            '.env'
        ]);

    (new AppSearch(
        $configStorage,
        $argv
    ))->run();
} catch (\Exception $th) {
    echo $th->getMessage();
    echo PHP_EOL;
}
