<?php

declare(strict_types=1);

namespace Damir\OtusHw6;

class App
{
    /**
     * @return string
     */
    public function run(): string
    {
        $emailChecker = new Email($_SERVER['argv'][1]);
        $emails = $emailChecker->getValidEmails();
        return 'Список валидных email: ' . implode(' ', $emails) . PHP_EOL;
    }
}