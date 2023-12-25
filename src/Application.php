<?php

namespace WorkingCode\Hw5;

use WorkingCode\Hw5\Validator\EmailValidator;

class Application
{
    public function run(): array
    {
        $emails         = $_POST['emails'] ?? [];
        $emailValidator = new EmailValidator();

        return array_filter(
            $emails,
            fn (string $email) => $emailValidator->validate($email)
        );
    }
}
