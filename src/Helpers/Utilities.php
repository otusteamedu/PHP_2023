<?php
declare(strict_types=1);

namespace Ekovalev\Otus\Helpers;

class Utilities
{
    /**
     * @param string $email
     * @return array
     * */
    public static function emailVerification(string $email):array
    {
        $res = [];

        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Почта $email не валидна!");
            }

            $emailDomain = explode('@', $email);

            if (!checkdnsrr($emailDomain[1], "MX")) {
                throw new \Exception("MX запись для $emailDomain[1] не найдена!");
            }
        } catch (\Exception $e) {
            $res['error'] = $e->getMessage();
        }


        $res['status'] = isset($res['error']) ? 'bad' : 'ok';

        return $res;

    }
}