<?php
namespace Shabanov\Otusphp;

class Result
{
    private array $errors;
    public function __construct() {}

    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return (!empty($this->errors))
            ? $this->errors
            : [];
    }

    public function isSuccess(): bool
    {
        return empty($this->errors);
    }
}
