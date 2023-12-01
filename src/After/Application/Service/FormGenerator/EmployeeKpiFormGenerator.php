<?php

declare(strict_types=1);

namespace App\Service\FormGenerator;

use App\After\Domain\Entity\EmployeeKpi;

class EmployeeKpiFormGenerator implements FormGeneratorInterface
{
    public function __construct(readonly EntityManagerInterface $entityManager)
    {
    }

    public function generate(string $date): array
    {
        [$month, $year] = explode('.', $date);
        $kpiDate = \DateTime::createFromFormat('Y-m-d', "$year-$month-01");
        $employees = $this->entityManager->getRepository(EmployeeKpi::class)->findEmployeeWithoutKpi($date);

        $forms['employee_kpi'] = [];
        foreach ($employees as $employee) {
            $formData = [
                'employee' => $employee,
                'date' => $kpiDate,
                'points' => 1,
                'comment' => '',
            ];
            $forms['employee_kpi'][] = $formData;
        }

        return $forms;
    }
}
