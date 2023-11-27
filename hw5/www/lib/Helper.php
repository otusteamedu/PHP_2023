<?php
namespace Shabanov\Otus;

class Helper {
    private const REG_EMAIL = '/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i';

    public static function checkEmails(array $arEmails): string
    {
        $return = '';
        if (!empty($arEmails)) {
            foreach($arEmails as $email) {
                $return .= 'Проверка валидности email: ' . self::checkEmail($email) . PHP_EOL;
                $return .= 'Проверка валидности MX записи домена: ' . self::checkMxDomain($email) . PHP_EOL;
            }
        }
        return $return;
    }

    public static function checkEmail(string $email): bool
    {
        if (preg_match(self::REG_EMAIL, $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkMxDomain(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        $result = getmxrr($domain, $mx_records, $mx_weight);
        if (!$result || count($mx_records) == 0
            || (count($mx_records) == 1
                && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"))
        ) {
            return false;
        } else {
            return true;
        }
    }
}
