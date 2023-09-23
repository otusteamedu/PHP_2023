<?php

declare(strict_types=1);

try {
    $string = $_POST['string'] ?? '';

    if (empty($string)) {
        throw new Exception("String parameter is empty");
    }
    if (!isValidString($string)) {
        throw new Exception("Your string '$string' contains invalid parentheses");
    }


    http_response_code(200);
    echo "OK: Your String '$string' is valid";
} catch (Exception $e) {
    http_response_code(400);
    echo "Bad Request: " . $e->getMessage();
}

function isValidString($str): bool
{
    $count = 0;

    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] == '(') {
            $count++;
        } elseif ($str[$i] == ')') {
            $count--;
        }
        if ($count < 0) {
            return false;
        }
    }
    return $count == 0;
}
