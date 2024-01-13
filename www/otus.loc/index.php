<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["string"]) && checkRequest($_POST["string"])) {
        header("HTTP/1.1 200 OK");
        echo "Всё хорошо";
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo "Всё плохо";
    }
}

function checkRequest(string $string): bool
{
    $length = strlen($string);

    // 0. Check string length
    if ($length % 2 != 0) {
        return false;
    }

    // 1. Check first and last characters
    if ($string[0] !== '(' || $string[$length - 1] !== ')') {
        return false;
    }

    // 2. Check balanced parentheses
    $counter = 0;
    for ($i = 0; $i < $length; $i++) {
        if ($string[$i] === '(') {
            $counter++;
        } elseif ($string[$i] === ')') {
            $counter--;
        }
        if ($counter < 0) {
            return false;
        }
    }

    return $counter === 0;
}