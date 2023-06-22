<?php

require_once './validator.php';
require_once './view.php';

if ($_REQUEST) {
    $validator = new \app\Validator($_POST);
    $response = $validator->validate('string');

    header($response['header_status']);
    header($response['header_response']);
    echo $response['response_message'];
} else {
    echo $view;
}
