<?php

declare(strict_types=1);

namespace Vasilaki\Php2023\Validatos;

class EmailDNSValidator
{
    /**
     * @var array
     */
    private $errors = [];

    public function __construct(
        private string $email
    )
    {

    }


    public function validate(): bool
    {
        $result = false;
        $validateEmail = $this->validateEmail($this->email);
        if ($validateEmail) {
            $validateDns = $this->validateDns($this->email);
            if ($validateDns) {
                $result = true;
            }
        } else {
            $this->errors[] = sprintf('%s is not email address', $this->email);
        }
        return $result;
    }

    private function validateDns(string $email): bool
    {
        list(, $hostName) = explode('@', $email);
        $mailList = [];
        getmxrr($hostName, $mailList);
        return (0 < count($mailList));
    }

    private function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
