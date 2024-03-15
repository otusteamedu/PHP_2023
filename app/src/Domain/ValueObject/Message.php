<?php

namespace App\Domain\ValueObject;

use Exception;

class Message extends AbstractValueObject
{
    /**
     * @param string $value
     * @return mixed
     */
    protected function validation(string $value): mixed
    {
        return;
    }
}
