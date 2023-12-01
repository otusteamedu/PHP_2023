<?php

namespace Daniel\Otus;

class App
{
    public function init()
    {
        $emailVerifier = new EmailVerifier();

        $emailVerifier->setVerifyEmails([
            'test@example.com',
            'invalid-email@',
            'valid.email@domain.com'
        ]);

        $emailVerifier->verifyEmails();
        $emailVerifier->printValidEmails();
    }
}
