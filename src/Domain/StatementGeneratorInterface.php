<?php

declare(strict_types=1);

namespace User\Php2023\Domain;

interface StatementGeneratorInterface
{
    public function generateStatement($startDate, $endDate): Statement;
}
