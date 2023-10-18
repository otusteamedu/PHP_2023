<?php

declare(strict_types=1);

namespace src;

class App
{
    /**
     * @throws EmailIsNotValidException
     */
    public function run(): void
    {
        $email = $_SERVER['argv'][1];

        if (!$email) {
            throw new EmailIsNotValidException();
        }

        $emailVerification = new EmailChecker();

        $emailVerification->verification($email);

        $emailVerification->verificationByDNS($email);

        echo "email $email is valid";
    }
}
