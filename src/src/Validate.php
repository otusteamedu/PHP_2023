<?php

declare(strict_types=1);

namespace nikitaglobal;

class Validate
{
    private $result = true;
    public function __construct()
    {
    }

    public function validate(): void
    {
        if (empty($_POST) || 1 !== count($_POST)) {
            $this->generateResponse(400);
            return;
        }
        if (isset($_POST['string'])) {
            $this->checkString();
        } elseif (isset($_POST['email'])) {
            $this->checkEmails();
        } else {
            $this->generateResponse(400);
        }
        return;
    }

    public function checkString(): void
    {
        $inputString = $_POST['string'] ?? '';
        if ('' === $inputString) {
            $this->generateResponse(400);
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
                $this->generateResponse(400);
            }
        }
        0 === $bracketsCount ? $this->generateResponse(200) : $this->generateResponse(400);
        return;
    }

    public function checkEmails(): Validate
    {
        $inputEmails = $_POST['email'] ?? '';
        if ('' === $inputEmails) {
            return $this;
        }
        $emails = explode(',', $inputEmails);
        foreach ($emails as $email) {
            if (false === $this->checkEmail($email) || false === $this->checkEmailMx($email)) {
                $this->result = false;
                return $this;
            }
        }
        return $this;
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
        return !!filter_var($inputEmail, FILTER_VALIDATE_EMAIL) && checkdnsrr(explode('@', $inputEmail)[1], 'MX');
    }

    public function generateResponse($code = 200): void
    {
        http_response_code($code);
        return;
    }
}
