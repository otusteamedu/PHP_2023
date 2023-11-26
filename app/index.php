<?php

declare(strict_types=1);

require('./Services/ValidBrackets.php');

use app\Services\ValidBrackets;

$string = $_POST['string'] ?? null;

try {
    $isValidBrackets = new ValidBrackets($string);
    $status = $isValidBrackets->check();
} catch (Exception $e) {
    http_response_code(400);
    exit($e->getMessage());
}
http_response_code(200);
