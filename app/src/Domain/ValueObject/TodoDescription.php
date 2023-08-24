<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidTodoDescriptionException;

class TodoDescription
{
    private string $value;

    /**
     * @param string $description
     * @throws InvalidTodoDescriptionException
     */
    public function __construct(string $description)
    {
        if (strlen($description) < 10 || !preg_match('/^[A-Z][A-Za-z0-9]{10,}$/', $description)) {
            throw new InvalidTodoDescriptionException(
                'Description must start with a capital letter, contain Latin characters, numbers and 
                be at least 10 characters long.'
            );
        }
        $this->value = $description;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
