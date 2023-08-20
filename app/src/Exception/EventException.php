<?php

declare(strict_types=1);

namespace App\Exception;

class EventException extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function priorityNotFound(): self
    {
        return new self('priority not found');
    }

    public static function eventDataNotFound(): self
    {
        return new self('event data not found');
    }
}