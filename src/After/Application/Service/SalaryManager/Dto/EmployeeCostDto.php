<?php

declare(strict_types=1);

namespace App\Service\SalaryManager\Dto;

use App\After\Domain\Entity\CashBonus;
use App\After\Domain\Entity\ContractType;
use App\After\Domain\Entity\CorrectionSum;
use App\After\Domain\Entity\Employee;
use App\After\Domain\Entity\HourlyRate;
use App\After\Domain\ValueObject\EmployeeCost\Checking;
use App\After\Domain\ValueObject\EmployeeCost\SumCalculatedToPay;
use App\After\Domain\ValueObject\EmployeeCost\SumKpiCashPrize;
use App\After\Domain\ValueObject\EmployeeCost\SumPlannedTax;
use App\After\Domain\ValueObject\EmployeeCost\SumSalary;
use App\After\Domain\ValueObject\EmployeeCost\WorkingHours;

class EmployeeCostDto
{
    public ?Employee $employee = null;
    public ?ContractType $contractType = null;
    public ?HourlyRate $hourlyRate = null;
    public ?CashBonus $cashBonus = null;
    public ?CorrectionSum $correctionSum = null;
    public ?SumSalary $sumSalary = null;
    public ?SumCalculatedToPay $sumToPay = null;
    public ?Checking $checking = null;
    public ?SumPlannedTax $plannedTax = null;
    public ?WorkingHours $workingHours = null;
    public ?SumKpiCashPrize $kpiCashPrize = null;
}
