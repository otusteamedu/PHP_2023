<?php

namespace App\After\Domain\Entity;

use App\After\Domain\Entity\CashBonus;
use App\After\Domain\Entity\CorrectionSum;
use App\After\Domain\Entity\Employee;
use App\After\Domain\Entity\HourlyRate;
use App\After\Domain\ValueObject\EmployeeCost\Checking;
use App\After\Domain\ValueObject\EmployeeCost\Comment;
use App\After\Domain\ValueObject\EmployeeCost\FullCost;
use App\After\Domain\ValueObject\EmployeeCost\LastSalary;
use App\After\Domain\ValueObject\EmployeeCost\SumBonus;
use App\After\Domain\ValueObject\EmployeeCost\SumCalculatedToPay;
use App\After\Domain\ValueObject\EmployeeCost\SumCorrect;
use App\After\Domain\ValueObject\EmployeeCost\SumKpiCashPrize;
use App\After\Domain\ValueObject\EmployeeCost\SumPlannedTax;
use App\After\Domain\ValueObject\EmployeeCost\SumSalary;
use App\After\Domain\ValueObject\EmployeeCost\SumSalaryBudgetTax;
use App\After\Domain\ValueObject\EmployeeCost\WorkingHours;

class EmployeeCost
{
    private ?Employee $employee = null;

    private ?\DateTimeInterface $date = null;

    private ?SumSalary $sumSalary = null;

    private ?SumBonus $sumBonus = null;

    private ?SumCorrect $sumCorrect = null;

    private ?SumCalculatedToPay $sumCalculatedToPay = null;

    private ?SumPlannedTax $sumPlannedTax = null;

    private ?SumKpiCashPrize $sumKpiCashPrize = null;

    private ?LastSalary $lastSalary = null;

    private ?\DateTimeImmutable $createdAt = null;

    private ?\DateTimeImmutable $updatedAt = null;

    private ?SumSalaryBudgetTax $sumSalaryBudgetTax = null;

    private ?Checking $checking = null;

    private ?WorkingHours $workingHours = null;

    private ?Comment $comment = null;

    private ?FullCost $fullCost = null;

    private ?HourlyRate $hourlyRate = null;

    private ?CashBonus $cashBonus = null;

    private ?CorrectionSum $correctionSum = null;

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSumSalary(): ?float
    {
        return $this->sumSalary;
    }

    public function setSumSalary(float $sumSalary): self
    {
        $this->sumSalary = $sumSalary;

        return $this;
    }

    public function getSumBonus(): float
    {
        return $this->sumBonus;
    }

    public function setSumBonus(float $sumBonus): self
    {
        $this->sumBonus = $sumBonus;

        return $this;
    }

    public function getSumCorrect(): float
    {
        return $this->sumCorrect;
    }

    public function setSumCorrect(float $sumCorrect): self
    {
        $this->sumCorrect = $sumCorrect;

        return $this;
    }

    public function getSumCalculatedToPay(): ?float
    {
        return $this->sumCalculatedToPay;
    }

    public function setSumCalculatedToPay(?float $sumCalculatedToPay): self
    {
        $this->sumCalculatedToPay = $sumCalculatedToPay;

        return $this;
    }

    public function getSumPlannedTax(): float
    {
        return $this->sumPlannedTax;
    }

    public function setSumPlannedTax(float $sumPlannedTax): self
    {
        $this->sumPlannedTax = $sumPlannedTax;

        return $this;
    }

    public function getSumKpiCashPrize(): float
    {
        return $this->sumKpiCashPrize;
    }

    public function setSumKpiCashPrize(float $sumKpiCashPrize): self
    {
        $this->sumKpiCashPrize = $sumKpiCashPrize;

        return $this;
    }

    public function getLastSalary(): ?float
    {
        return $this->lastSalary;
    }

    public function setLastSalary(float $lastSalary): self
    {
        $this->lastSalary = $lastSalary;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSumSalaryBudgetTax(): float
    {
        return $this->sumSalaryBudgetTax;
    }

    public function setSumSalaryBudgetTax(float $sumSalaryBudgetTax): self
    {
        $this->sumSalaryBudgetTax = $sumSalaryBudgetTax;

        return $this;
    }

    public function getChecking(): float
    {
        return $this->checking;
    }

    public function setChecking(float $checking): static
    {
        $this->checking = $checking;

        return $this;
    }

    public function getWorkingHours(): ?int
    {
        return $this->workingHours;
    }

    public function setWorkingHours(int $workingHours): static
    {
        $this->workingHours = $workingHours;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getFullCost(): ?float
    {
        return $this->fullCost;
    }

    public function setFullCost(float $fullCost): static
    {
        $this->fullCost = $fullCost;

        return $this;
    }

    public function getHourlyRate(): ?HourlyRate
    {
        return $this->hourlyRate;
    }

    public function setHourlyRate(?HourlyRate $hourlyRate): static
    {
        $this->hourlyRate = $hourlyRate;

        return $this;
    }

    public function getCashBonus(): ?CashBonus
    {
        return $this->cashBonus;
    }

    public function setCashBonus(?CashBonus $cashBonus): static
    {
        $this->cashBonus = $cashBonus;

        return $this;
    }

    public function getCorrectionSum(): ?CorrectionSum
    {
        return $this->correctionSum;
    }

    public function setCorrectionSum(?CorrectionSum $correctionSum): static
    {
        $this->correctionSum = $correctionSum;

        return $this;
    }
}
