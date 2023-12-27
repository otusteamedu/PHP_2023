<?php

declare(strict_types=1);

namespace Chernomordov\App;

class App
{
    /**
     * @return string
     */
    public function run(): string
    {
        $emailChecker = new EmailVerifier($_SERVER['argv'][1]);
        $emails = $emailChecker->verifyEmails();
        return 'Список валидных email: ' . implode(' ', $emails) . PHP_EOL;
    }
}
