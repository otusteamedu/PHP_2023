<?php

declare(strict_types=1);

namespace Gesparo\HW\ValueObject;

class Message
{
    private string $message;

    public function __construct(string $message)
    {
        $this->assertNotEmpty($message);

        $this->message = $message;
    }

    private function assertNotEmpty(string $message): void
    {
        if (empty($message)) {
            throw new \InvalidArgumentException('Message can not be empty');
        }
    }

    public function getValue(): string
    {
        return $this->message;
    }
}
