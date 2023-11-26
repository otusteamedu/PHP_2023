<?php

declare(strict_types=1);

use Yevgen87\App\Services\ValidBrackets;

require __DIR__ . '/vendor/autoload.php';

$string = $_POST['string'] ?? null;

try {
    $isValidBrackets = new ValidBrackets($string);
    $status = $isValidBrackets->check();
} catch (Exception $e) {
    http_response_code(400);
    exit($e->getMessage());
}
http_response_code(200);
