<?php

declare(strict_types=1);

namespace Kanakhin\EmailValidation\Application;

use Kanakhin\EmailValidation\Domain\Email;
use Exception;

class EmailValidater
{
    public function run(array $args): void {
        if (empty($args[1])) {
            throw new Exception("No email given");
        }

        $email = new Email($args[1]);

        if ($email->emailCorrect()) {
            echo 'Email correct';
        } else {
            echo 'Email incorrect';
        }
    }
}