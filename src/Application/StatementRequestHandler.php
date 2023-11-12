<?php

declare(strict_types=1);

namespace User\Php2023\Application;

use Exception;
use User\Php2023\Domain\ValueObject\DateRange;
use User\Php2023\Infrastructure\Queue\QueueInterface;

class StatementRequestHandler
{
    private QueueInterface $queue;

    public function __construct(QueueInterface $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @throws Exception
     */
    public function handleRequest(DateRange $dateRange): void
    {
        $message = [
            'start_date' => $dateRange->getStartDateAsString(),
            'end_date' => $dateRange->getEndDateAsString()
        ];
        $this->queue->push($message);
    }
}
