<?php

namespace App\Helpers;

use App\Model\Email;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use RuntimeException;

class EmailValidator
{
    protected array $DNS = [];
    protected Collection $emails;

    public function validate(array $emails): self
    {
        $this->emails = new ArrayCollection(array_map(function ($email) {
            $emailValidate = new Email((string)$email);
            $emailValidate->setIsValid(
                filter_var($emailValidate->getEmail(), FILTER_VALIDATE_EMAIL) &&
                $this->checkDNS($emailValidate->getEmail())
            );
            return $emailValidate;
        }, $emails));
        return $this;
    }

    public function printResult(): void
    {
        echo $this->getResult();
    }

    public function getResult(): string
    {
        $output = '';
        $this->emails->map(static function ($email) use (&$output) {
            $output .= sprintf('%s <br />', $email);
        });
        return $output;
    }

    public function checkDNS(string $email): bool
    {
        $domain = substr(strrchr($email, '@'), 1);
        if (isset($this->DNS[$domain])) {
            return $this->DNS[$domain];
        }

        try {
            $resultEmail = getmxrr($domain, $mx_records) && count($mx_records) > 0;
        } catch (RuntimeException $_) {
            $resultEmail = false;
        }

        $this->DNS[$domain] = $resultEmail;
        return $resultEmail;
    }
}
