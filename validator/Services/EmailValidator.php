<?php

declare(strict_types=1);

namespace Services;

use ValidationStrategies\EmailValidationStrategy;

class EmailValidator
{
    private array $validators = [];
    /**
     * @param \ValidationStrategies\EmailValidationStrategy $validator
     * @return void
     */
    public function addValidator(EmailValidationStrategy $validator): void
    {
        $this->validators[] = $validator;
    }
    /**
     * @param string $email
     * @return string
     */
    public function validate(string $email): string
    {
        $validationResults = $this->validateAll($email);
        foreach ($validationResults as $result) {
            if (!$result) {
                return 'Не верный Email';
            }
        }
        return 'Верный Email';
    }
    /**
     * @param string $email
     * @return array
     */
    public function validateAll(string $email): array
    {
        $results = [];
        foreach ($this->validators as $validator) {
            $results[] = $validator->validate($email);
        }
        return $results;
    }
}
