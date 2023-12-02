<?php

namespace Daniel\Otus;

class App
{
    public function init($postData)
    {
        if (isset($postData['emails']) && is_array($postData['emails'])) {
            $emailVerifier = new EmailVerifier();
            $emailVerifier->setVerifyEmails($postData['emails']);
            $emailVerifier->verifyEmails();
            $emailVerifier->printValidEmails();
        } else {
            echo "Invalid input data";
        }
    }
}
