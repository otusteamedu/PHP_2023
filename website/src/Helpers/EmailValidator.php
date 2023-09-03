<?php

namespace App\Helpers;

use App\Model\Email;
use Doctrine\Common\Collections\Collection;

class EmailValidator
{
    protected array $DNS = [];

    public function validate(Collection &$emails): void
    {
        /** @var Email $email */
        foreach ($emails as $email) {
            $email->setIsValid(filter_var($email->getEmail(), FILTER_VALIDATE_EMAIL) && $this->checkDNS($email->getEmail()));
        }
    }

    public function checkDNS(string $email): bool
    {
        $domain = substr(strrchr($email, '@'), 1);
        if (isset($this->DNS[$domain])) {
            return $this->DNS[$domain];
        }

        try {
            $resultEmail = getmxrr($domain, $mx_records) && count($mx_records) > 0;
        } catch (\RuntimeException $e) {
            $resultEmail = false;
        }

        $this->DNS[$domain] = $resultEmail;
        return $resultEmail;
    }
}
