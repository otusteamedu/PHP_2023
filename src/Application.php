<?php

declare(strict_types=1);

namespace Santonov\Otus;

class Application
{
    public function process(array $emails): array
    {
        $result = [];
        foreach ($emails as $email) {
            $result[$email] = Validator::isEmailValid($email, true) ? 'valid' : 'invalid';
        }

        return $result;
    }
}
