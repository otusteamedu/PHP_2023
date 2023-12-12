<?php

namespace App\Domain\ValueObject;

use Exception;

abstract class AbstractValueObject
{
    protected string $value;

    /**
     * @throws Exception
     */
    public function __construct(string $value)
    {
        $this->validation($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @throws Exception
     * @return void
     */
    abstract protected function validation(string $value): void;
}
