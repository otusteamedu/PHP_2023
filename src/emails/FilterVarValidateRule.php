<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\emails;

class FilterVarValidateRule implements ValidateRuleInterface
{
    public function validate(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
