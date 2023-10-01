<?php

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

require_once __DIR__ . '/vendor/autoload.php';

$emails = include './emails.php';

$validator = new EmailValidator();

try {
    foreach ($emails as $email) {
        if ($validator->isValid($email, new RFCValidation())) {
            echo 'email ' . $email . ' is valid' . PHP_EOL;
        } else {
            echo 'email ' . $email . ' is not valid' . PHP_EOL;
        }
    }
} catch (Exception $exception) {
    echo $exception->getMessage();
}