<?php

include '/data/mysite.local/vendor/autoload.php';

use VKorabelnikov\Hw6\SocketChat\Application;

error_reporting(E_ALL);

try {
    $app = new Application();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
