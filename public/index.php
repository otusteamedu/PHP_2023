<?php

declare(strict_types=1);

use MikhailArkhipov\Php2023\Validator;

require __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../config/variables_path.php';

$response_validator = null;
if (! is_null($_REQUEST['string'])) {
    $validator = new Validator($_REQUEST['string']);
    $response_validator = $validator->validate();
}

include_once VIEWS_DIR . 'main.php';
