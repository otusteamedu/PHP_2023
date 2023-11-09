<?php

namespace src;

use ErrorException;
use Exception;
use ReflectionClass;

set_exception_handler(
    /** @throws \ReflectionException */
    function (Exception $exception): void {
        echo PHP_EOL;
        echo 'Uncaught exception class: ' . (new ReflectionClass($exception::class))->getShortName();
        echo PHP_EOL;
        //echo 'Uncaught exception class: ' . get_class($exception) . PHP_EOL;
        //echo 'Uncaught exception class: ' . $exception::class . PHP_EOL;
        echo 'Message of uncaught exception: ' . $exception->getMessage();
        echo PHP_EOL;
        echo PHP_EOL;
    }
);

set_error_handler(
    /** @throws ErrorException */
    function ($severity, $message, $filename, $lineno) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
);
