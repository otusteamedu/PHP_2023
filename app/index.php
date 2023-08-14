<?php

declare(strict_types=1);

use Root\App\App;
use Root\App\ErrorHandler;
use Root\App\ExceptionHandler;

require __DIR__ . '/vendor/autoload.php';

$exceptionHandler = new ExceptionHandler();
$errorHandler = new ErrorHandler();
set_exception_handler($exceptionHandler);
set_error_handler($errorHandler);

$app = new App();
/** @noinspection PhpUnhandledExceptionInspection */
$app->run();
