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
        $errorMessage = '';
        $explodedEmails = explode(',', $emails);
        foreach ($explodedEmails as $email) {
            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                $errorMessage .= 'Email not valid: ' . $email . '. ';
            }
            $checkMx = checkdnsrr(explode('@', $email)[1]);
            if (!$checkMx) {
                $errorMessage .= 'Email Mx not valid: ' . $email . '. ';
            }
        }
        if (!empty($errorMessage)) {
            return ['message' => $errorMessage, 'code' => 400];
        }
        return ['message' => 'Is valid', 'code' => 200];
    }
}
