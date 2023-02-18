<?php

require 'autoload.php';

$validator = new Validator();
$request = new Request($_POST, $_SERVER['REQUEST_METHOD']);

try {
    $app = new App($request, $validator);
    $result = $app->run();

    header('HTTP/1.1 200 OK');
    echo $result . PHP_EOL;
} catch (BadRequestException $e) {
    header('HTTP/1.1 400 Bad Request');
    echo $e->getMessage() . PHP_EOL;
}
