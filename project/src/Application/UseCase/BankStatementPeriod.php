<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\Dto\Output\Result;
use Vp\App\Application\RabbitMq\Contract\SenderInterface;

class BankStatementPeriod
{
    private SenderInterface $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function createTask($message): Result
    {
        return $this->sender->send(QUEUE_BANK_STATEMENT_PERIOD, $message);
    }
}
