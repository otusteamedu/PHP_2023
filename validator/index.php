<?php

declare(strict_types=1);

require __DIR__ . '/Services/EmailValidator.php';

use Rvoznyi\ComposerHello\Services\EmailValidator;

if (isset($_REQUEST['email'])) {
    $emailValidator = new EmailValidator($_REQUEST['email']);
    return $emailValidator->validate();
} else {
    return 'Нет параметра email';
}
