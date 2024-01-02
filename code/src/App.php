<?php

declare(strict_types=1);

namespace Application;

use Application\Verifier\EmailVerifier;

class App
{
    public function run(): void
    {
        $emailVerifier = new EmailVerifier('test@lompom.ru, test2&rt.ru, job2100@mail.ru, tt@mail.ru');
        $validEmails = $emailVerifier->verify(); // Выведет job2100@mail.ru, tt@mail.ru
        if (!empty($validEmails)) {
            echo 'Список валидных email: ' . implode(', ', $validEmails) . PHP_EOL;
        } else {
            echo 'Список email адресов не прошёл верификацию';
        }
    }
}
