<?php

namespace Daniel\Otus;

class App
{
    public function init()
    {
        $emailVerifier = new EmailVerifier();

        $emailVerifier->verifyEmails();
        $emailVerifier->printValidEmails();
    }
}
