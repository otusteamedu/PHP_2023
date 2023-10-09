<?php

require __DIR__ . "/../../vendor/autoload.php";

use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Init\HttpApiInit;

var_dump($className, $method);die();

$init = new HttpApiInit();
$init->run();
