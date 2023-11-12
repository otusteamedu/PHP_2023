<?php
declare(strict_types=1);

namespace User\Php2023\Infrastructure\Controllers;

use User\Php2023\Application\Service\StatementQueueService;
use User\Php2023\DIContainer;
use User\Php2023\Domain\ValueObject\DateRange;

class StatementController
{

    public function __construct()
    {
    }

    public static function handlePostRequest(DIContainer $container): string
    {
        $statementQueueService = $container->get(StatementQueueService::class);
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        try {
            $dateRange = new DateRange($startDate, $endDate);
            return $statementQueueService->enqueueStatementRequest($dateRange);
        } catch (\Exception $e) {
            return "Ошибка: " . $e->getMessage();
        }
    }
}
