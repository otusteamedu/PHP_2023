<?php

namespace Yakovgulyuta\Hw5;

class EmailValidator
{
    /**
     * @return array{message: string, code: int}
    */
    public function validate(string $emails): array
    {
        if (empty($emails)) {
            return ['message' => 'Blank emails', 'code' => 400];
        }
        $explodedEmails = explode(',', $emails);
        foreach ($explodedEmails as $email) {
            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                return ['message' => 'Email not valid: ' . $email, 'code' => 400];
            }
            $checkMx = checkdnsrr(explode('@', $email)[1]);
            if (!$checkMx) {
                return ['message' => 'Email Mx not valid: ' . $email, 'code' => 400];
            }

        }
        return ['message' => 'Is valid', 'code' => 200];
    }
}