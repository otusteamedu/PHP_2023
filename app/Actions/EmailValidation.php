<?php

namespace app\Actions;

use app\Rules\EmailRule;
use app\Rules\MXRule;
use Generator;

class EmailValidation
{
    public function __invoke(array $emailList): array
    {
        $validEmails = [];
        $invalidEmails = [];
        $emails = $this->validateArray($emailList);
        foreach ($emails as $email) {
            $emailRule = (new EmailRule())->passes($email);
            $mxRule = (new MXRule())->passes($email);
            if ($emailRule || $mxRule) {
                $invalidEmails = $email;
                continue;
            }

            $validEmails[] = $email;
        }

        return ['validEmails' => $validEmails, 'invalidEmails' => $invalidEmails];
    }

    private function validateArray(array $emailList): Generator
    {
        $emails = array_unique($emailList);

        foreach ($emails as $email) {
            yield trim(htmlspecialchars($email));
        }
    }
}
