<?php

require_once './app/validator.php';
require_once './app/view.php';

if ($_REQUEST) {
    $validator = new Validator($_POST);
    $response = $validator->validate('string');

    header($response['header_status']);
    header($response['header_response']);
    echo $response['response_message'];
} else {
    echo $view;
}
