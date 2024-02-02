<?php

namespace ValidationStrategies;

class FilterVarEmailValidator implements \ValidationStrategies\EmailValidationStrategy
{
    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
