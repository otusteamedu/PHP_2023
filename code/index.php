<?php

declare(strict_types=1);

require_once 'Controllers/StringValidatorController.php';

use Controllers\StringValidatorController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? '';

    $result = StringValidatorController::validate($value);

    echo $result;
} else {
    http_response_code(405);
    echo "Метод не допустим";
}