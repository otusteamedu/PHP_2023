<?php

declare(strict_types=1);

require __DIR__ . '/Services/EmailValidator.php';

use Services\EmailValidator;
use ValidationStrategies\FilterVarEmailValidator;
use ValidationStrategies\MxRecordEmailValidator;

if (isset($_REQUEST['email'])) {
    $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
    if ($email === false) {
        echo 'Некорректный email';
    } else {
        $emailValidator = new EmailValidator();
        // Добавляем различные стратегии валидации
        $emailValidator->addValidator(new FilterVarEmailValidator());
        $emailValidator->addValidator(new MxRecordEmailValidator());
    }
} else {
    echo 'Нет параметра email';
}
