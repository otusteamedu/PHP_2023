<?php

namespace ValidationStrategies;

class MxRecordEmailValidator implements \ValidationStrategies\EmailValidationStrategy
{
    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        [$username, $domain] = explode('@', $email);
        return getmxrr($domain, $mxHosts);
    }
}
