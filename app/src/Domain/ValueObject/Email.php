<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Email extends AbstractValueObject
{
    protected function validation(string $value): void
    {
        return;
    }
}
