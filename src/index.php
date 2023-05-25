<?php

declare(strict_types=1);

function isStringValid(string $string): bool
{
    if (empty($string)) {
        return false;
    }

    $stack = [];

    foreach (str_split($string) as $char) {
        if ($char === '(') {
            $stack[] = $char;
        } elseif ($char === ')') {
            $lastChar = array_pop($stack);

            if ($lastChar !== '(') {
                return false;
            }
        } else {
            return false;
        }
    }

    return empty($stack);
}

[$httpCode, $responseText] = match (true) {
    !array_key_exists('string', $_POST) => [400, 'string param is required'],
    isStringValid($_POST['string']) => [200, 'You are good!'],
    default => [400, 'Incorrect string'],
};

http_response_code($httpCode);

echo $responseText;
