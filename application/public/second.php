<?php

declare(strict_types=1);

use Gesparo\Hw\Exception\HttpException;

require __DIR__ . "/../vendor/autoload.php";

function validateString(string $string): bool
{
    if ($string === '') {
        return false;
    }

    if (preg_match('/^[()]+$/', $string) !== 1) {
        return false;
    }

    $count = 0;
    $sizeOfString = strlen($string);

    for ($i = 0; $i < $sizeOfString; ++$i) {
        if ($string[$i] === '(') {
            ++$count;
        } else {
            --$count;
        }

        if ($count < 0) {
            return false;
        }
    }

    return $count === 0;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new HttpException('Invalid request method. Only post allowed', HttpException::BAD_REQUEST_400);
    }

    if (!array_key_exists('string', $_POST)) {
        throw new HttpException("Mismatched 'string' param", HttpException::BAD_REQUEST_400);
    }

    if (!validateString(trim($_POST['string']))) {
        throw new HttpException("'String' param is not valid", HttpException::BAD_REQUEST_400);
    }

    $string = trim($_POST['string']);

    echo "Your string '$string' is valid";
} catch (HttpException $exception) {
    header("HTTP/1.1 {$exception->getCode()} {$exception->getMessage()}");
}
