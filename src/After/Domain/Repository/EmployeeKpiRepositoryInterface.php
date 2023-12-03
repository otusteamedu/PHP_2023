<?php

declare(strict_types=1);

namespace App\After\Domain\Repository;

interface EmployeeKpiRepositoryInterface
{
    public function findEmployeeWithoutKpi(string $filterDate): array;

    public function findEmployeeByProjectWithoutKpi(string $projectName, string $currentYearAndPreviousMonth): array;
}
