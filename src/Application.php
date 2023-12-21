<?php

namespace WorkingCode\Hw5;

use WorkingCode\Hw5\Validator\EmailValidator;

class Application
{
    public function run(): void
    {
        $emails = $_POST['emails'] ?? [];
        $emailValidator = new EmailValidator();

        foreach ($emails as $email){
            if ($emailValidator->validate($email)){
                echo "$email валиден\n";
            } else {
                echo "$email не валиден\n";
            }
        }
    }
}
