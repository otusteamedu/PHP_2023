<?php

function verifyEmail($email) {
    $regex = '/^[\w\.\-]+@[\w\.\-]+\.[a-zA-Z]{2,}$/';

    if (!preg_match($regex, $email)) {
        return false;
    }

    $domain = substr(strrchr($email, "@"), 1);

    if (!checkdnsrr($domain)) {
        return false;
    }

    return true;
}

function verifyEmails(array $emails) {
    $validEmails = [];
    foreach ($emails as $email) {
        if (verifyEmail($email)) {
            $validEmails[] = $email;
        }
    }
    return $validEmails;
}

$emailsToVerify = [
    'test@example.com',
    'invalid-email@',
    'valid.email@domain.com'
];

$validEmails = verifyEmails($emailsToVerify);

echo "Valid emails:\n";
print_r($validEmails);
