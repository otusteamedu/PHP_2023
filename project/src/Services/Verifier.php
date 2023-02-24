<?php
declare(strict_types=1);

namespace Vp\App\Services;

class Verifier
{
    private const VALID = 'valid';
    private const INVALID = 'invalid';
    private array $result = [];

    public function verification(array $emails): void
    {
        foreach ($emails as $email) {
            $this->result[$email] = $this->checkEmail($email) ? self::VALID : self::INVALID;
        }
    }

    private function checkEmail(string $email): bool
    {
        return $this->checkRegExp($email) && $this->checkMx($email);
    }

    private function checkRegExp(string $email): bool
    {
        $pattern = "/^[a-z0-9]+[a-z0-9!'#$%&.*+\/=?^_`{|}~-]+(?:\.[a-z0-9!'#$%&*+\/=?^_`{|}~-]+)*@(?:[а-яa-z0-9](?:[а-яa-z0-9-]*[а-яa-z0-9])?\.)+[рфa-zA-Z]{2,}$/ui";

        return (bool)preg_match($pattern, $email);
    }

    private function checkMx(string $email): bool
    {
        [,$domain] = explode('@', $email);

        return (bool)checkdnsrr($domain, 'MX');
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
