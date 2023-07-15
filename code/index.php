<?php

require_once './vendor/autoload.php';

use app\Validator;

if ($_POST) {
    $request = $_POST;
    $validator = new \app\Validator($request);
    $response = $validator->validate('string');

    header($response['header_status']);
    header($response['header_response']);
    echo $response['response_message'];
} else {
    echo $view;
}
