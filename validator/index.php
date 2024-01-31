<?php

declare(strict_types=1);

require __DIR__ . '/Services/EmailValidator.php';

use Rvoznyi\ComposerHello\Services\EmailValidator;

if (isset($_REQUEST['email'])) {
    $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
    if ($email === false) {
        echo 'Некорректный email';
    } else {
        $emailValidator = new EmailValidator($email);
        echo $emailValidator->validate();
    }
} else {
    echo 'Нет параметра email';
}
