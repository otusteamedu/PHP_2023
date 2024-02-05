<?php

declare(strict_types=1);

namespace Services;

use ValidationStrategies\EmailValidationStrategy;

class EmailValidator
{
    private array $validators = [];
    /**
     * EmailValidator constructor.
     * @param array $validators
     */
    public function __construct(array $validators = [])
    {
        $this->validators = $validators;
    }
    /**
     * @param EmailValidationStrategy $validator
     * @return void
     */
    public function addValidator(EmailValidationStrategy $validator): void
    {
        $this->validators[] = $validator;
    }
    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        $validationResults = $this->validateAll($email);
        foreach ($validationResults as $result) {
            if (!$result) {
                return false; // Если хотя бы один валидатор вернул false, весь email считается невалидным
            }
        }
        return true; // Все валидаторы вернули true, email считается валидным
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
