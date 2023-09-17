<?php

namespace Root\Www\Exception;

use RuntimeException;

final class ValidationException extends RuntimeException
{
    private $errors;

    public function addError($message): void
    {
        $this->errors[] = $message;
    }

    public function getErrors(): array | null
    {
        return $this->errors;
    }
}
