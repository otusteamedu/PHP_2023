<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\Dto\Output\ResultSend;
use Vp\App\Application\Producer\Contract\SenderInterface;

class BankStatementPeriod
{
    private SenderInterface $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function createTask($message): ResultSend
    {
        return $this->sender->send(QUEUE_BANK_STATEMENT_PERIOD, $message);
    }
}
