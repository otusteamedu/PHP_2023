<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\MyApp;

try {
    $myApp = new MyApp();
    $myApp->init();
    $result = $myApp->search();
    print_r($result);
} catch (Throwable $th) {
    print_r($th->getMessage());
}
