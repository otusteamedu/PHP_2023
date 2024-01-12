<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Request;

class CheckFinishedMessageRequest
{
    public ?string $messageId;

    public function __construct(?string $messageId)
    {
        $this->messageId = $messageId;
    }
}
