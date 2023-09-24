<?php

declare(strict_types=1);

namespace Eevstifeev\Emailvalidator\Controllers;

use Eevstifeev\Emailvalidator\Services\EmailValidator;

class EmailValidateController
{

    public static function getValidate(array $emailList): array
    {
        $result = [];
        $emailValidator = new EmailValidator();
        foreach ($emailList as $email) {
            $result[$email] = ($emailValidator->validate($email)) ?'Валидный email' : 'Невалидный email';
        }
        return $result;
    }
}