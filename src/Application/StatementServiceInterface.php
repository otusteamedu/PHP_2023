<?php

declare(strict_types=1);

namespace User\Php2023\Application;

interface StatementServiceInterface
{
    public function requestStatementGeneration($startDate, $endDate): void;
}
