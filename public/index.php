<?php

include_once(__DIR__ . '/src/autoload.php');

$stringValidatorService = new \src\Services\StringValidatorService();
$string = $_POST['string'];

if ($stringValidatorService->isBracketsValid($string)) {
    http_response_code(200);
    echo 'Input string is valid';
} else {
    http_response_code(400);
    echo 'Input string is not valid';
}
