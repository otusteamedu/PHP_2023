<?php

declare(strict_types=1);

use Root\App\App;
use Root\App\ErrorHandler;
use Root\App\ExceptionHandler;
use Root\App\Settings;

require __DIR__ . '/vendor/autoload.php';

$exceptionHandler = new ExceptionHandler();
$errorHandler = new ErrorHandler();
set_exception_handler($exceptionHandler);
set_error_handler($errorHandler);

$settings = new Settings('./config.ini');

$app = new App($settings);
/** @noinspection PhpUnhandledExceptionInspection */
$app->run();
