<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\emails;

use Ndybnov\Hw06\exceptions\KeyRuleUsedRuntimeException;

class Validator
{
    private array $errors;
    private array $rules;

    public function __construct()
    {
        $this->errors = [];
        $this->rules = [];
    }

    public function addRule(string $key, ValidateRuleInterface $ruleClass): void
    {
        if (isset($this->rules[$key])) {
            throw new KeyRuleUsedRuntimeException("The key [$key] used already!");
        }
        $this->rules[$key] = $ruleClass;
    }

    public function fromString(string $emails): int
    {
        return $this->emails(explode(',', $emails));
    }

    public function emails(array $emails): int
    {
        $rules = $this->getRules();
        foreach ($emails as $email) {
            $this->byEmail($email, $rules);
        }

        return count($this->errors);
    }

    private function getRules(): array
    {
        return $this->rules;
    }

    private function byEmail($email, $rules): void
    {
        /** @var ValidateRuleInterface $rule */
        foreach ($rules as $key => $rule) {
            if (!$rule->validate($email)) {
                $uniqKey = "[$key] ~ [$email]";
                $this->errors[$uniqKey] = "Incorrect value `$email` by rule `$key`.";
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
