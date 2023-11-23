<?php

$memcached = new Memcached();
$memcached->addServer('memcached1', 11211);
$memcached->addServer('memcached2', 11212);

/**
 * Check if the string has balanced brackets.
 *
 * @param string $str The input string.
 * @return bool True if the brackets are balanced, false otherwise.
 */
function isBracketsBalanced(string $str): bool
{
    $balance = 0;

    for ($i = 0, $len = strlen($str); $i < $len; $i++) {
        if ($str[$i] === '(') {
            $balance++;
        } elseif ($str[$i] === ')') {
            $balance--;
            if ($balance < 0) {
                return false; // More closing brackets than opening ones
            }
        }
    }

    return $balance === 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['string']) && is_string($_POST['string'])) {
        $string = $_POST['string'];

        $isBalanced = isBracketsBalanced($string);
        $memcached->set('last_check_result', 'memcache');

        if (isBracketsBalanced($string)) {
            http_response_code(200);
            echo 'OK: The string is correct.';
            $value = $memcached->get('last_check_result');

            echo 'This is '. $value;
        } else {
            http_response_code(400);
            echo 'Bad Request: The string is incorrect.';
        }
    } else {
        http_response_code(400);
        echo 'Bad Request: Missing or invalid "string" parameter.';
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed: This endpoint only supports POST requests.';
}