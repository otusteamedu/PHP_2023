<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Validate\EmailValidatorProxy;

$testEmailAddresses = [
    'test@domain.com',
    'test@johnconde.net',
    'test@gmail.com',
    'test@hotmail.com',
    'test@outlook.com',
    'test@yahoo.com',
    'test@domain.com',
    'test@mxfuel.com',
    'test@example.com',
    'test@example2.com',
    'test@nobugmail.com',
    'test@cellurl.com',
    'test@10minutemail.com',
    'test+example@gmail.com',
];

try {
    $emailValidator = new EmailValidatorProxy();
    foreach ($testEmailAddresses as $address) {
        $emailIsValid = $emailValidator->validate($address);
        echo ($emailIsValid) ? 'Email is valid' : $emailValidator->getError();
        echo PHP_EOL;
    }
} catch (Exception $exception) {
    echo $exception->getMessage();
}
