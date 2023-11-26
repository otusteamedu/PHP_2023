<?php
$emails = $_POST['emails'] ?? null;

$emails = explode(',', $emails);
$validEmails = getValidEmails($emails);
print_r($validEmails);

function getValidEmails(array $emails = []): array
{
    $validEmails = [];
    foreach ($emails as $email) {
        $email = trim($email);
        $isValidEmailString = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$isValidEmailString) {
            continue;
        }

        $domain = substr(strrchr($email, "@"), 1);
        $isExistMxForDomain = getmxrr($domain, $mx_records, $mx_weight);
        if (!$isExistMxForDomain) {
           continue;
        }
        $validEmails[] = $email;
    }

    return $validEmails;
}
