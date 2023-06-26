<?php

namespace EmailVerification;

class EmailVerifier
{
    /**
     * Проверяет, является ли адрес электронной почты валидным.
     *
     * @param string $email Адрес электронной почты для проверки.
     * @return bool Возвращает true, если адрес электронной почты валидный, иначе false.
     */
    public static function isValidEmail($email)
    {
        // Проверка с помощью регулярного выражения
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Проверка наличия MX-записи в DNS
        list(, $domain) = explode('@', $email);
        if (!checkdnsrr($domain, 'MX')) {
            return false;
        }

        return true;
    }

    /**
     * Проверяет список адресов электронной почты на валидность.
     *
     * @param array $emailList Список адресов электронной почты для проверки.
     * @return array Массив с результатами проверки в формате ['email' => 'valid'].
     */
    public static function verifyEmailList(array $emailList)
    {
        $results = [];

        foreach ($emailList as $email) {
            $isValid = self::isValidEmail($email);
            $results[$email] = $isValid ? 'valid' : 'invalid';
        }

        return $results;
    }
}
