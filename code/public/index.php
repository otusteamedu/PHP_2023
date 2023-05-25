<?php

include __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw4\Application\App;

try {
    $obApp = new App();
    echo $obApp->run();
} catch (\Exception $obThrownException) {
    http_response_code(400);
    echo $obThrownException->getMessage();
}
