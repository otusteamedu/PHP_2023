<?php

declare(strict_types=1);

namespace Aleksandrdolgov\OtusPhp2023;

use Exception;

function validateString(string $string): bool {
    if (preg_match('/^(\((?1)*\))*$/', $string)) {
        return true;
    } else {
        return false;
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Use POST method', 400);
    }

    $string = $_POST['string'] ?? '';

    if (empty($string)) {
        throw new Exception('Send me not empty "string" param', 400);
    }

    if (validateString($string)) {
        echo sprintf('Скобки в строке "<b>%s</b>" прошли валидацию', $string);
    } else {
        echo sprintf('Строка "<b>%s</b>" не прошла валидацию на скобки', $string);
    }
} catch (Exception $exception) {
    header("HTTP/1.1 {$exception->getCode()} {$exception->getMessage()}");
}