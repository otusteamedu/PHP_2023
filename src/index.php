<?php

require __DIR__ . '/../vendor/autoload.php';

use Daniel\Otus\EmailVerifier;

$emailsToVerify = [
    'test@example.com',
    'invalid-email@',
    'valid.email@domain.com'
];

$emailVerifier = new EmailVerifier();

$emailVerifier->verifyEmails($emailsToVerify);
$emailVerifier->printValidEmails();
