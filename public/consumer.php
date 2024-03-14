<?php

declare(strict_types=1);

use App\Rabbit\Client;
use App\Rabbit\Config;
use App\Rabbit\Consumer;

define("APP_PATH", dirname(__DIR__));

require_once APP_PATH . "/vendor/autoload.php";

try {
    $config = new Config();
    $client = new Client($config);
    $consumer = new Consumer($client);
    $consumer->consume();
} catch (Exception $e) {
    echo $e->getMessage();
}
