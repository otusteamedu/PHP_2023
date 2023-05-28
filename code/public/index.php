<?php

include __DIR__ . "/../vendor/autoload.php";

try {
    $app = new VKorabelnikov\Hw5\EmailVerificator\Application();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
