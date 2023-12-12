<?php

namespace App\Domain\ValueObject;

use Exception;

class Name extends AbstractValueObject
{
    protected function validation(string $value): void
    {
        return;
    }
}
