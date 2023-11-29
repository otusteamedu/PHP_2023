<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\ValidatorString;
use App\ValidatorRequest;

http_response_code(400);

try {
    ValidatorRequest::check();
    ValidatorString::check($_POST['text']);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

http_response_code(200);
header('Content-Type: text/plain; charset=utf-8');
echo 'This text has been verified!';
