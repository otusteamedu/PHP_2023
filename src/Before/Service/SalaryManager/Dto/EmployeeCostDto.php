<?php

declare(strict_types=1);

namespace App\Service\SalaryManager\Dto;

use App\After\Domain\ValueObject\EmployeeCost\Checking;
use App\After\Domain\ValueObject\EmployeeCost\SumCalculatedToPay;
use App\After\Domain\ValueObject\EmployeeCost\SumKpiCashPrize;
use App\After\Domain\ValueObject\EmployeeCost\SumPlannedTax;
use App\After\Domain\ValueObject\EmployeeCost\SumSalary;
use App\After\Domain\ValueObject\EmployeeCost\WorkingHours;
use App\Entity\CashBonus;
use App\Entity\ContractType;
use App\Entity\CorrectionSum;
use App\Entity\Employee;
use App\Entity\HourlyRate;

class EmployeeCostDto
{
    public ?Employee $employee = null;
    public ?ContractType $contractType = null;
    public ?HourlyRate $hourlyRate = null;
    public ?CashBonus $cashBonus = null;
    public ?CorrectionSum $correctionSum = null;
    public ?float $sumSalary = null;
    public ?float $sumToPay = null;
    public ?float $checking = null;
    public ?float $plannedTax = null;
    public ?int $workingHours = null;
    public ?float $kpiCashPrize = null;
}
