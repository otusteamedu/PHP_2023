<?php
include '/data/mysite.local/vendor/autoload.php';


// use VKorabelnikov\Hw6\SocketChat\Application;


error_reporting(E_ALL);

try {
    $app = new VKorabelnikov\Hw6\SocketChat\Application();
    $app->run();
}
catch (Exception $e) {
    var_dump($e);
}