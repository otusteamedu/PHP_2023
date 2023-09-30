<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\MyApp;

try {
    $client = MyApp::createClientES();
    $myApp = new MyApp($client);
    $myApp->init();
    $myApp->search();
} catch (Throwable $th) {
    print_r($th->getMessage());
}
