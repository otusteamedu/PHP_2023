<?php

namespace src;

use ErrorException;
use Exception;
use ReflectionClass;

set_exception_handler(
    static function (Exception $exception): void {
        echo PHP_EOL;
        echo 'Uncaught exception class: ' . (new ReflectionClass(get_class($exception)))->getShortName();
        echo PHP_EOL;
        echo 'Message of uncaught exception: ' . $exception->getMessage();
        echo PHP_EOL;
        echo PHP_EOL;
    }
);

set_error_handler(
    /** @throws ErrorException */
    static function ($severity, $message, $filename, $lineno) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
);
