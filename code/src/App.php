<?php

declare(strict_types=1);

namespace Application;

use Application\Verifier\EmailVerifier;

class App
{
    public function run(): array
    {
        $emailList = $_REQUEST['emails'] ?? '';
        $emailVerifier = new EmailVerifier($emailList);
        return $emailVerifier->verify();
    }
}
