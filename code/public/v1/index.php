<?php

require __DIR__ . "/../../vendor/autoload.php";

use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Init\HttpApiInit;

$init = new HttpApiInit();
$init->run();
