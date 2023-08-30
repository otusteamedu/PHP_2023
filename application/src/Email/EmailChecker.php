<?php

declare(strict_types=1);

namespace Gesparo\Hw\Email;

use Gesparo\Hw\Exception\EmailException;

class EmailChecker
{
    private DomainChecker $domainChecker;

    public function __construct(DomainChecker $domainChecker)
    {
        $this->domainChecker = $domainChecker;
    }

    /**
     * @throws EmailException
     * @throws \JsonException
     */
    public function check(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return $this->domainChecker->check($this->getDomainName($email));
    }

    private function getDomainName(string $email): string
    {
        if (preg_match('/@((\w|\d)+[^.]\.[a-z]+)/', strtolower($email), $matches) !== 1) {
            throw new \LogicException("Cannot get domain name from the email address '$email'");
        }

        return $matches[1];
    }
}
