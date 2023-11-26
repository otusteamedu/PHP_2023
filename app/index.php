<?php

declare(strict_types=1);

require('./Service/isValidBrackets.php');

$string = $_POST['string'] ?? null;

try {
    $isValidBrackets = new isValidBrackets($string);
    $status = $isValidBrackets->check();
} catch (Exception $e) {
    http_response_code(400);
    exit($e->getMessage());
}
http_response_code(200);
