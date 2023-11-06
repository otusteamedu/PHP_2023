<?php

$param_name = 'string';
$param_value = '(()()()())((((()()())) (()()()(((())))) )) )';
$url = "nginx";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $count = 0;
    $error = false;
    foreach (str_split($_POST[$param_name]) as $char) {
        if ($char == '(') {
            $count++;
        } elseif ($char == ')') {
            $count--;
        }

        if ($count < 0) {
            $error = true;
        }
    }

    if ($count != 0) {
        $error = true;
    }

    if ($error) {
        $header = 'HTTP/1.0 400 Bad Request';
        $message = ' Всё плохо';
    } else {
        $header = 'HTTP/1.0 200 OK';
        $message = ' Всё хорошо';
    }

    header($header);
    echo $message;
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$param_name=$param_value");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$output = curl_exec($ch);
$info = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

echo 'Код отвеета сервера: ' . $info . PHP_EOL;
echo $output;
