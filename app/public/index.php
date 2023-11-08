<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Infrastructure\Request\Request;
use App\Infrastructure\Controllers\SomeController;

$stringJson = '{"card_number":"12","card_holder":"Test Test","card_expiration":"10/25","cvv":123,"order_number":"213","sum":10}';
$stringJson1 = '{"card_number":"1111111111111111","card_holder":"Test Test","card_expiration":"10/25","cvv":123,"order_number":"213","sum":10}';
$request = new Request($stringJson1);

$response =  (new SomeController())->someAction($request);
var_dump($response);
