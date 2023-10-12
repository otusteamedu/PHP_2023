<?php

declare(strict_types=1);

require __DIR__ . '/Services/EmailValidator.php';

use \app\validator\EmailValidator;

if (isset($_REQUEST['email'])) {
    $emailValidator = new EmailValidator($_REQUEST['email']);
    return $emailValidator->validate();
} else {
    echo 'Отсутствует параметр email';
}
