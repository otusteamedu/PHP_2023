<?php

function getValidEmails($emails): Generator
{
    foreach($emails as $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            continue;
        }

        $domain = substr(strrchr($email, "@"), 1);
        $result = getmxrr($domain, $mx_records, $mx_weight);
        if (empty($mx_records)) {
            continue;
        }

        yield $email;
    }
}

function getResultFromGenerator($generator): string
{
    $result = '';
    foreach ($generator as $item) {
        $result .= $item . "\n";
    }

    return $result;
}
