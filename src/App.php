<?php

declare(strict_types=1);

namespace App;

use App\Service\EmailValidatorService;
use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        // get email from GET param
        $email = $_GET['email'] ?? null;

        if (empty($email)) {
            throw new Exception('Email is empty');
        }

        $emailValidatorService = new EmailValidatorService();
        $isValidEmail = $emailValidatorService->validateEmail($email);

        if ($isValidEmail) {
            echo 'Email is valid' . PHP_EOL;
        } else {
            echo 'Email is not valid' . PHP_EOL;
        }
    }
}
