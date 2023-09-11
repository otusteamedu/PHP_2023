<?php

declare(strict_types=1);

use MikhailArkhipov\Php2023\Validator;

require __DIR__ . '/../vendor/autoload.php';

$response_validator = null;
if (array_key_exists('string', $_REQUEST) && ! is_null($_REQUEST['string'])) {
    $validator = new Validator($_REQUEST['string']);
    $response_validator = $validator->validate();
}

include_once __DIR__ . '/../views/main.php';