<?php

namespace ValidationStrategies;

interface EmailValidationStrategy
{
    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool;
}
