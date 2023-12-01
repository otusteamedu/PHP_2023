<?php

declare(strict_types=1);

namespace App\Before\Service\FormGenerator;

use App\Entity\EmployeeKpi;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeKpiFormGenerator
{
    public static function generate(string $date, array $employees): array
    {
        [$month, $year] = explode('.', $date);
        $kpiDate = \DateTime::createFromFormat('Y-m-d', "$year-$month-01");

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
