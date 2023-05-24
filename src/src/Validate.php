<?php

declare(strict_types=1);

namespace nikitaglobal;

class Validate
{
    private $result = false;
    public function __construct()
    {
    }
    public function checkString(): Validate
    {
        $inputString = $_POST['string'] ?? '';
        if ('' === $inputString) {
            return $this;
        }

        $bracketsCount = 0;

        for ($i = 0; $i < strlen($inputString); $i++) {
            if ($inputString[$i] == '(') {
                $bracketsCount++;
            } elseif ($inputString[$i] == ')') {
                $bracketsCount--;
            }
            if ($bracketsCount < 0) {
                return $this;
            }
        }
        0 === $bracketsCount ? $this->result = true : $this->result = false;
        return $this;
    }

    public function checkEmail(): Validate
    {
        $inputEmail = $_POST['email'] ?? '';
        if ('' === $inputEmail) {
            return $this;
        }
        $this->result = filter_var($inputEmail, FILTER_VALIDATE_EMAIL);
        return $this;
    }

    public function checkEmailMx(): Validate
    {
        $inputEmail = $_POST['email'] ?? '';
        if ('' === $inputEmail) {
            return $this;
        }
        $this->result = filter_var($inputEmail, FILTER_VALIDATE_EMAIL) && checkdnsrr(explode('@', $inputEmail)[1], 'MX');
        return $this;
    }

    public function generateResponse()
    {
        $this->result ? http_response_code(200) : http_response_code(400);
        exit();
    }
}
