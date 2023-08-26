<?php

declare(strict_types=1);

include_once __DIR__ . '/../config/variables_path.php';
include_once APP . 'validator.php';

$response_validator = null;
if ($_REQUEST) {
    $validator = new app\Validator($_POST);
    $response = $validator->validate('string');

    header($response['header_status']);
    header($response['header_response']);
    $response_validator = $response['response_message'];
}

include_once VIEWS_DIR . 'main.php';
