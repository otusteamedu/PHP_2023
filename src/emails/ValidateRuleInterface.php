<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\emails;

interface ValidateRuleInterface
{
    public function validate(string $email): bool;
}
