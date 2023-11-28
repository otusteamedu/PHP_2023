<?php

require_once __DIR__ . '/autoload.php';

use App\EmailVerifier;

$emailsToVerify = [
    'test@example.com',
    'invalid-email@',
    'valid.email@domain.com'
];

$emailVerifier = new EmailVerifier();
$validEmails = $emailVerifier->verifyEmails($emailsToVerify);

echo "Valid emails:\n";
print_r($validEmails);
