<?php

namespace Sherweb\Validate;

/**
 * Validate email
 * Class Email
 */
class Email
{
    /**
     * Validate single email
     * @param string $email
     * @return bool
     */
    public static function validateEmail(string $email): bool
    {
        // Проверка с использованием регулярного выражения
        if (!preg_match("/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/", $email)) {
            return false;
        }

        // Проверка с использованием DNS MX записи
        $domain = explode("@", $email)[1];
        if (!checkdnsrr($domain, "MX")) {
            return false;
        }

        return true;
    }

    /**
     * Validate email list
     * @param array $emailList
     * @return array[]
     */
    public static function validateEmailList(array $emailList): array
    {
        $validEmails = [];
        $invalidEmails = [];

        foreach ($emailList as $email) {
            if (self::validateEmail($email)) {
                $validEmails[] = $email;
            } else {
                $invalidEmails[] = $email;
            }
        }

        return [
            "validEmails" => $validEmails,
            "invalidEmails" => $invalidEmails,
        ];
    }
}