<?php

namespace YakovGulyuta\Hw15\Domain\Exception;

class EntityNotFoundException extends \DomainException
{

    public function __construct(string $message, int $code)
    {
        parent::__construct($message , $code);
    }
}