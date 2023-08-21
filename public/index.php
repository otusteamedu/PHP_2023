<?php

declare(strict_types=1);

$entityBody = file_get_contents('php://input');

$body = json_decode($entityBody, true);

if (!isset($body['string'])) {
    http_response_code(400);
    throw new Exception('String not found', 400);
}

$string = $body['string'];

$arrayOfBrackets = str_split($string);

$numberOfOpeningBrackets = 0;

for ($i = 0; $i <= count($arrayOfBrackets) - 1; $i++) {
    $item = $arrayOfBrackets[$i];

    if ($item == '(') {
        $numberOfOpeningBrackets++;
    } elseif ($item == ')') {
        $numberOfOpeningBrackets--;
    }

    if ($numberOfOpeningBrackets < 0) {
        http_response_code(400);
        throw new Exception("String is not correct. Character number $i", 400);
    }
}

echo 'String is valid';
