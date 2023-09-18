<?php

require_once __DIR__ . '/vendor/autoload.php';

if (!empty($_POST['string'])) {
    $expression = $_POST['string'];
    $expressionIsCorrect = StringValidator::isValid($expression);

    if ($expressionIsCorrect) {
        http_response_code(200);
        echo "Expression is correct";
        exit;
    }
}

http_response_code(400);
echo "Wrong expression!";
