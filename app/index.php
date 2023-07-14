<?php
declare(strict_types=1);


use Root\App\App;
use Root\App\AppException;

require __DIR__ . '/vendor/autoload.php';

$config = __DIR__ . '/config.ini';


try {
    $app = new App($config);
    $app->run();
} catch (AppException $e) {
    echo 'App error. ', $e->getMessage(), PHP_EOL;
} catch (Exception | Error $e) {
    echo 'Oops! Something went wrong. ', $e->getMessage(), PHP_EOL;
}
