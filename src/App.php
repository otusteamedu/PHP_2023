<?php

declare(strict_types=1);

namespace Damir\OtusHw6;

class App
{
    /**
     * @return void
     */
    public function run(): void
    {
        $emailChecker = new Email($_SERVER['argv'][1]);
        $emails = $emailChecker->getValidEmails();
        echo 'Список валидных email: ' . implode(' ', $emails) . PHP_EOL;
    }
}