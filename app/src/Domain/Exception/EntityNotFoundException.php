<?php

namespace YakovGulyuta\Hw15\Domain\Exception;

use DomainException;

class EntityNotFoundException extends DomainException
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
