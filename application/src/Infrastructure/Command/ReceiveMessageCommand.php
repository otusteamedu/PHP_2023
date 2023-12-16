<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure\Command;

use Gesparo\Homework\Application\Service\ReceiveMessageService;

class ReceiveMessageCommand
{
    public function __construct(
        private readonly ReceiveMessageService $receiveMessageService
    )
    {
    }

    public function execute(): void
    {
        $this->receiveMessageService->receive();
    }
}
