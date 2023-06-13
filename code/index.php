<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $string = $_POST['string'];

    if (empty($string) or !preg_match('/[()]/', $string)) {
        http_response_code(400);
        echo 'Bad Request // Все плохо';
        exit;
    }

    $openBrackets = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        if ($string[$i] === '(') {
            $openBrackets++;
        } elseif ($string[$i] === ')') {
            $openBrackets--;
        }

        if ($openBrackets < 0) {
            http_response_code(400);
            echo 'Bad Request';
            exit;
        }
    }

    if ($openBrackets !== 0) {
        http_response_code(400);
        echo 'Bad Request';
        exit;
    }

    http_response_code(200);
    echo 'OK';
    exit;
}
