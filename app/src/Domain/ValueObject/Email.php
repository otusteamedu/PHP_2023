<?php

namespace App\Domain\ValueObject;

use Exception;

class Email extends AbstractValueObject
{
    protected function validation(string $value): void
    {
        return;
    }
}
