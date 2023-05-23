<?php

declare(strict_types=1);

namespace PHP_2023\Bocukom\EmailValidation;
use Exception;

class EmailValidation
{
    private $emailList = [];

    function __construct(array $emailList) {
        if (empty($emailList))
            throw new Exception('The array cannot be empty');
        $this->emailList = $emailList;
    }

    public function isValid() : array
    {
        $result = [];
        foreach ($this->emailList as $email) {
            $isEmailReg = (is_string($email)) ? $this->checkReg($email) : false;
            $isEmailMX = (is_string($email)) ? $this->checkMX($email) : false;
            $isEmailTotal = ($isEmailReg && $isEmailMX) ? true : false;
            $result[$email] = ['isValid' => $isEmailTotal];
        }
        return $result;
    }
    private function checkReg(string $email) : bool
    {
        return (preg_match("~([a-zA-Z0-9!#$%&'*+-/=?^_`{|}])@([a-zA-Z0-9-]).([a-zA-Z0-9]{2,4})~", $email)) ? true : false; 
    }
    private function checkMX(string $email) : bool
    {
        $emailArray = explode('@', $email);
        $hostname = end($emailArray);
        return getmxrr($hostname, $mxhosts);
    }
}
