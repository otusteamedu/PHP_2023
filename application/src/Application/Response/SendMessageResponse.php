<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Response;

class SendMessageResponse
{
    public function __construct(
        public readonly string $messageId
    ) {
    }

    public function toArray(): array
    {
        return [
            'messageId' => $this->messageId
        ];
    }
}
