<?php

namespace Sherweb;

use Sherweb\Validate\Email;

class ValidateEmailApp
{
    public static function run(array $emailList): void
    {
        $result = Email::validateEmailList($emailList);
        echo "Valid Emails: " . implode(", ", $result["validEmails"]) . "<br>";
        echo "Invalid Emails: " . implode(", ", $result["invalidEmails"]) . "<br>";
    }
}