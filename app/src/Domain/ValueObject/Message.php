<?php

namespace App\Domain\ValueObject;

use Exception;

class Message extends AbstractValueObject
{
    protected function validation(string $value): void
    {
        return;
    }
}
