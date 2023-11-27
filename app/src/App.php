<?php

declare(strict_types=1);

namespace Artyom\Php2023;

use Artyom\Php2023\helpers\ResponseHelper;
use Artyom\Php2023\validator\EmailValidator;

class App
{
    /**
     * @return string
     */
    public function run(): string
    {
        $emails         = isset($_POST['emails']) ? (array)$_POST['emails'] : [];
        $emailValidator = new EmailValidator();
        $result         = $emailValidator->validate($emails);

        if ($result) {
            return ResponseHelper::successResponse('Получены валидные emails: ' . implode(', ', $result));
        } else {
            return ResponseHelper::errorResponse('Не было получено ни одного валидного email');
        }
    }
}
