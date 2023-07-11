<?php

namespace app\Actions;

use app\Rules\EmailRule;
use app\Rules\MXRule;
use Generator;

class EmailValidation
{
    public function __invoke(array $emailList): string
    {
        $emails = $this->validateArray($emailList);

        foreach ($emails as $email) {
            $emailRule = (new EmailRule())->passes($email);
            $mxRule = (new MXRule())->passes($email);
            if ($emailRule || $mxRule) {
                return "Email $email is not valid" . PHP_EOL;
            }
        }

        return 'All emails are valid' . PHP_EOL;
    }

    private function validateArray(array $emailList): Generator
    {
        $emails = array_unique($emailList);

        foreach ($emails as $email) {
            yield trim(htmlspecialchars($email));
        }
    }
}
