<?php

declare(strict_types=1);

use Aporivaev\Hw06\Hw06;

require __DIR__ . '/../vendor/autoload.php';

$email = [ 'email@email.email', 'email@email.com', 'email@example.com', 'email.email', 'email+1@example.com',
    'email-1@example.com', 'email=1@example.com', 'email\1@example.com', 'email*1@example.com'];

if (isset($argc) && isset($argv) && is_array($argv)) {
    if ($argc > 1) {
        $email = array_slice($argv, 1);
    }
}

echo json_encode(Hw06::emailValidation($email), JSON_UNESCAPED_UNICODE);
