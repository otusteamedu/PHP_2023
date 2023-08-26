<?php

declare(strict_types=1);

use Gesparo\Hw\App;

require "../vendor/autoload.php";

try {
    (new App())->run($argv);
} catch (Throwable $exception) {
    $trace = json_encode($exception->getTrace(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
    $message = <<<EOL
        Exception: '{$exception->getMessage()}'
        Code: '{$exception->getCode()}'
        Trace:
        
        $trace
    EOL;

    fwrite(STDERR, $message . PHP_EOL);
}
