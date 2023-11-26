<?php

namespace DimAl\Homework5\Application;

use Exception;
use DimAl\Homework5\Services\EmailCheckService;

class App
{
    public function run($email)
    {
        $this->emailIsWrong($email);
    }

    public function checkEmailsFromFile($file): array
    {
        $ret = [];
        $emls = file($file);
        foreach ($emls as $eml) {
            $eml = trim($eml);
            $check_result = $this->emailIsWrong($eml);
            array_push($ret, [
                'email' => $eml,
                'status' => $check_result ? $check_result : 'OK'
            ]);
        }
        return $ret;
    }

    public function emailIsWrong($email)
    {
        $checker = new EmailCheckService();

        try {
            if (!$checker->checkEmailFormat($email)) {
                throw new Exception("wrong email format");
            }

            if (!$checker->checkEmailMxDomain($email)) {
                throw new Exception("wrong mx domain");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return false;
    }
}
