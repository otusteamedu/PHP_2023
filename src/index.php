<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Validator;

if (!empty($_POST['string'])) {
    $expression = $_POST['string'];
    $expressionIsCorrect = Validator::checkIfBalanced($expression);

    if ($expressionIsCorrect) {
        http_response_code(200);
        echo "Выражение корректно";
        exit;
    }
}

http_response_code(400);
echo "Выражение не корректно";

