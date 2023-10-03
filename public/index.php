<?php

include __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw5\EmailVerificator\Application;

try {
    $app = new Application();
    echo $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
