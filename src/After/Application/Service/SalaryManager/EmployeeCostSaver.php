<?php

declare(strict_types=1);

namespace App\Service\SalaryManager;

use App\After\Application\Service\Calculator\QuarterlyCalculator\CashPrizeCalculator;
use App\After\Application\Service\Calculator\QuarterlyCalculator\SalaryUpCalculator;
use App\After\Application\Service\Calculator\TaxCalculator\Tax13Calculator;
use App\After\Application\Service\Calculator\TaxCalculator\Tax6Calculator;
use App\After\Application\Service\SalaryManager\Dto\EmployeeCostDto;
use App\After\Domain\CashBonus;
use App\After\Domain\ContractType;
use App\After\Domain\CorrectionSum;
use App\After\Domain\Employee;
use App\After\Domain\EmployeeCost;
use App\After\Domain\EmployeeKpi;
use App\After\Domain\FactoryCalendar;
use App\After\Domain\HourlyRate;
use DateTime;
use DateTimeImmutable;
use Exception;

class EmployeeCostSaver implements CostManagerInterface
{
    /**
     * Dates mean months without SAVE_QUARTERLY_SALARY_DATES. Dates format(m-d).
     */
    private const SAVE_MONTHLY_SALARY_DATES = [
        '01-05',
        '03-05',
        '04-05',
        '06-05',
        '07-05',
        '09-05',
        '10-05',
        '12-05',
    ];

    private DateTime $currentDate;

    public function __construct(
        readonly EntityManagerInterface $entityManager
    ) {
        $this->currentDate = new DateTime();
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $monthDayFormat = $this->currentDate->format('m-d');

        if (in_array($monthDayFormat, self::SAVE_MONTHLY_SALARY_DATES)) {
            $this->calculateMonthlyEmployeeCost();

            return;
        }

        throw new Exception("The current date is not correct: {$this->currentDate->format('Y-m-d')}");
    }

    /**
     * @throws Exception
     */
    private function calculateMonthlyEmployeeCost(): void
    {
        $employees = $this->entityManager->getRepository(Employee::class)->findAll();

        foreach ($employees as $employee) {
            $salaryCurrent = $employee->getSalaryCurrent();
            $contractType = $employee->getContractType();
            $hourlyRate = $employee->getHourlyRate();
            $cashBonus = $this->findCashBonus($employee);
            $sumCorrect = $this->findCorrectionSum($employee);

            if ($this->isEmployeeOnlyReceiveBonus($salaryCurrent, $contractType)) {
                $employeeCostDto = new EmployeeCostDto();
                $employeeCostDto->employee = $employee;
                $employeeCostDto->contractType = $contractType;
                $employeeCostDto->hourlyRate = $hourlyRate;
                $employeeCostDto->cashBonus = $cashBonus;
                $employeeCostDto->correctionSum = $sumCorrect;
                $employeeCostDto->sumToPay = $this->calculateSumToPay($employeeCostDto);

                $this->newEmployeeCost($employeeCostDto);
                continue;
            }

            $updatedSalary = $this->updateSalary($salaryCurrent, $sumCorrect, $cashBonus);
            $plannedTax = $this->calculatePlannedTax($contractType, $updatedSalary);
            $salaryWithNdfl = $updatedSalary + $plannedTax;

            if (!$this->isValidHourlyRate($salaryWithNdfl, $hourlyRate)) {
                $hourlyRate = $this->findHourlyRate($salaryWithNdfl);
            }

            $workingHours = $this->calculateWorkingHours($hourlyRate, $salaryWithNdfl);
            $checking = $this->calculateChecking($contractType, $hourlyRate, $workingHours, $salaryWithNdfl);

            $employeeCostDto = new EmployeeCostDto();
            $employeeCostDto->employee = $employee;
            $employeeCostDto->contractType = $contractType;
            $employeeCostDto->sumSalary = $salaryCurrent;
            $employeeCostDto->plannedTax = $plannedTax;
            $employeeCostDto->workingHours = $workingHours;
            $employeeCostDto->hourlyRate = $hourlyRate;
            $employeeCostDto->cashBonus = $cashBonus;
            $employeeCostDto->correctionSum = $sumCorrect;
            $employeeCostDto->checking = $checking;
            $employeeCostDto->sumToPay = $this->calculateSumToPay($employeeCostDto);

            $this->newEmployeeCost($employeeCostDto);
        }

        $this->entityManager->flush();
    }

    private function findCashBonus(Employee $employee): ?CashBonus
    {
        return $this->entityManager->getRepository(CashBonus::class)->findOneBy([
            'employee' => $employee,
            'date' => (new DateTimeImmutable())->modify('first day of this month'),
        ]);
    }

    private function findCorrectionSum(Employee $employee): ?CorrectionSum
    {
        return $this->entityManager->getRepository(CorrectionSum::class)->findOneBy([
            'employee' => $employee,
            'date' => (new DateTimeImmutable())->modify('first day of this month'),
        ]);
    }

    private function isEmployeeOnlyReceiveBonus(float $salaryCurrent, ContractType $contractType): bool
    {
        return 0.0 === $salaryCurrent && in_array($contractType->getTitle(), ['ИП', 'Самозанятый']);
    }

    private function calculateSumToPay(EmployeeCostDto $employeeCostDto): float
    {
        $bonus = $employeeCostDto->cashBonus?->getSum() ?? 0;
        $correction = $employeeCostDto->correctionSum?->getSum() ?? 0;

        $sum = $employeeCostDto->sumSalary
            + $employeeCostDto->kpiCashPrize
            + $bonus
            + $employeeCostDto->checking
            + $correction;

        if (in_array($employeeCostDto->contractType->getTitle(), ['ИП', 'Самозанятый'])) {
            $sum += $employeeCostDto->plannedTax;
        }

        return $sum;
    }

    /**
     * @throws Exception
     */
    private function newEmployeeCost(EmployeeCostDto $employeeCostDto): void
    {
        $employeeCost = new EmployeeCost();
        $employeeCost->setEmployee($employeeCostDto->employee);
        $employeeCost->setDate((new DateTimeImmutable())->modify('first day of this month'));
        $employeeCost->setSumSalary($employeeCostDto->sumSalary);
        $employeeCost->setChecking($employeeCostDto->checking);
        $employeeCost->setWorkingHours($employeeCostDto->workingHours);
        $employeeCost->setHourlyRate($employeeCostDto->hourlyRate);
        $employeeCost->setSumPlannedTax($employeeCostDto->plannedTax);
        $employeeCost->setCashBonus($employeeCostDto->cashBonus);
        $employeeCost->setCorrectionSum($employeeCostDto->correctionSum);
        $employeeCost->setSumKpiCashPrize($employeeCostDto->kpiCashPrize);
        $employeeCost->setLastSalary($employeeCostDto->sumSalary);
        $employeeCost->setSumCalculatedToPay($employeeCostDto->sumToPay);
        $employeeCost->setFullCostAutomatically();
        $employeeCost->setCreatedAtAutomatically();
        $employeeCost->setUpdatedAtAutomatically();

        $this->entityManager->persist($employeeCost);
    }

    private function updateSalary(float $salaryCurrent, ?CorrectionSum $correctionSum, ?CashBonus $cashBonus): float
    {
        $bonus = $cashBonus?->getSum() ?? 0;
        $correction = $correctionSum?->getSum() ?? 0;

        return $salaryCurrent + $bonus + $correction;
    }

    private function calculatePlannedTax(ContractType $contractType, float $sumToPay): float
    {
        return match ($contractType->getTitle()) {
            'ТД', 'ГПХ' => Tax13Calculator::calc($sumToPay),
            'ИП', 'Самозанятый' => Tax6Calculator::calc($sumToPay),
            default => 0
        };
    }

    private function isValidHourlyRate(float $sumToPay, HourlyRate $hourlyRate): bool
    {
        $rate = $hourlyRate->getRate();

        return !$this->isZeroHourlyRate($rate) && $this->isValidWorkingHours((int)ceil($sumToPay / $rate));
    }

    private function isZeroHourlyRate(int $hourlyRate): bool
    {
        return 0 === $hourlyRate;
    }

    private function isValidWorkingHours(int $workHours): bool
    {
        return $workHours <= $this->getWorkHoursFromFactoryCalendar();
    }

    private function getWorkHoursFromFactoryCalendar(): ?int
    {
        $factoryCalendar = $this->entityManager->getRepository(FactoryCalendar::class)->findOneBy([
            'date' => (new DateTimeImmutable())->modify('first day of this month'),
        ]);

        return $factoryCalendar->getWorkHours();
    }

    private function findHourlyRate(float $salaryWithNdfl): HourlyRate
    {
        $hourlyRateAll = $this->entityManager->getRepository(HourlyRate::class)->findAll();
        $standardWorkHours = $this->getWorkHoursFromFactoryCalendar();
        $standardHourlyRate = (int)ceil($salaryWithNdfl / $standardWorkHours);

        $selectedRate = null;
        foreach ($hourlyRateAll as $hourlyRate) {
            if (
                $hourlyRate->getRate() >= $standardHourlyRate
                && (null === $selectedRate || $hourlyRate->getRate() < $selectedRate->getRate())
            ) {
                $selectedRate = $hourlyRate;
            }
        }

        return $selectedRate;
    }

    private function calculateWorkingHours(HourlyRate $hourlyRate, float $sumToPay): int
    {
        return (int)ceil($sumToPay / $hourlyRate->getRate());
    }

    private function calculateChecking(ContractType $contractType, HourlyRate $hourlyRate, int $workingHours, float $sumToPay): float
    {
        return match ($contractType->getTitle()) {
            'ТД', 'ГПХ' => $workingHours * $hourlyRate->getRate() - $sumToPay,
            default => 0
        };
    }
}
