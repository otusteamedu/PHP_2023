<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use YuzyukRoman\Verification\Email\Email;

$arrEmails = [
    ["test"],
    123,
    'test@test.test',
    'romantyzyukfront@gamil.com',
    'roman.yuzyuk@lenvendo.ru',
];

$verificationEmails = new Email();

$verificationEmails->setEmails($arrEmails);
print_r($verificationEmails->verifyEmails());
