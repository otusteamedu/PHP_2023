<?php

declare(strict_types=1);

namespace nikitaglobal;

use nikitaglobal\Responses as Responses;

class Validate
{
    private $result = true;
    public function __construct()
    {
    }

    public function validate(): void
    {
        if (empty($_POST) || 1 !== count($_POST)) {
            Responses::error();
            return;
        }
        if (isset($_POST['string'])) {
            $this->checkString();
        } elseif (isset($_POST['email'])) {
            $this->checkEmails();
        } else {
            Responses::error();
        }
        return;
    }

    public function checkString(): void
    {
        $inputString = $_POST['string'] ?? '';
        if ('' === $inputString) {
            Responses::error();
            return;
        }

        $bracketsCount = 0;

        for ($i = 0; $i < strlen($inputString); $i++) {
            if ($inputString[$i] == '(') {
                $bracketsCount++;
            } elseif ($inputString[$i] == ')') {
                $bracketsCount--;
            }
            if ($bracketsCount < 0) {
                Responses::error();
                return;
            }
        }

        0 === $bracketsCount ? Responses::success() : Responses::error();
        return;
    }

    public function checkEmails(): void
    {
        $inputEmails = $_POST['email'] ?? '';
        if ('' === $inputEmails) {
            Responses::error();
            return;
        }
        $emails = explode(',', $inputEmails);
        foreach ($emails as $email) {
            if (false === $this->checkEmail($email) || false === $this->checkEmailMx($email)) {
                Responses::error();
                return;
            }
        }
        Responses::success();
    }

    public function checkEmail(string $inputEmail = ''): bool
    {
        if ('' === $inputEmail) {
            return false;
        }
        return !!filter_var($inputEmail, FILTER_VALIDATE_EMAIL);
    }

    public function checkEmailMx($inputEmail): bool
    {
        if ('' === $inputEmail) {
            return false;
        }
        return checkdnsrr(explode('@', $inputEmail)[1], 'MX');
    }
}
