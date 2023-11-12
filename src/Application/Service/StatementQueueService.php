<?php

declare(strict_types=1);

namespace User\Php2023\Application\Service;

use User\Php2023\Application\StatementRequestHandler;
use User\Php2023\Domain\ValueObject\DateRange;

class StatementQueueService
{
    private StatementRequestHandler $requestHandler;

    public function __construct(StatementRequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    public function enqueueStatementRequest(DateRange $dateRange): string
    {
        try {
            $this->requestHandler->handleRequest($dateRange);
            return "Запрос на генерацию выписки за период с {$dateRange->getStartDateAsString()} по {$dateRange->getEndDateAsString()} принят в обработку.";
        } catch (\Exception $e) {
            return "Ошибка: " . $e->getMessage();
        }
    }
}
