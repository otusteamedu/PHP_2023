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
     * @return bool
     */
    public function validate(string $email): bool
    {
        $validationResults = $this->validateAll($email);
        // Проверяем все результаты валидации
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
    /**
     * @param string $email
     * @return void
     */
    public function displayValidationResults(string $email): void
    {
        // Пример вывода результатов валидации
        foreach ($this->validateAll($email) as $index => $result) {
            echo 'Validator ' . ($index + 1) . ': ' . ($result ? 'Valid' : 'Invalid') . '<br>';
        }
        // Пример вывода общего результата
        echo 'Overall Result: ' . ($this->validate($email) ? 'Valid' : 'Invalid');
    }
}
