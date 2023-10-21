<?php

require __DIR__ . "/../../vendor/autoload.php";

use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Init\HttpApiInit;

// var_dump($className, $method);die();

$init = new HttpApiInit();
$init->run();
