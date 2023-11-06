<?php

declare(strict_types=1);

namespace App\Entity;

class FactoryCalendar
{
    private ?int $id = null;

    private ?\DateTimeInterface $date = null;

    private ?int $workHours = null;

    private ?int $calendarDays = null;

    private ?int $workDays = null;

    private ?int $weekendHolidaysDays = null;

    private ?\DateTimeImmutable $createdAt = null;

    private ?\DateTimeImmutable $updatedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getWorkHours(): ?int
    {
        return $this->workHours;
    }

    public function setWorkHours(int $workHours): static
    {
        $this->workHours = $workHours;

        return $this;
    }

    public function getCalendarDays(): ?int
    {
        return $this->calendarDays;
    }

    public function setCalendarDays(int $calendarDays): static
    {
        $this->calendarDays = $calendarDays;

        return $this;
    }

    public function getWorkDays(): ?int
    {
        return $this->workDays;
    }

    public function setWorkDays(int $workDays): static
    {
        $this->workDays = $workDays;

        return $this;
    }

    public function getWeekendHolidaysDays(): ?int
    {
        return $this->weekendHolidaysDays;
    }

    public function setWeekendHolidaysDays(int $weekendHolidaysDays): static
    {
        $this->weekendHolidaysDays = $weekendHolidaysDays;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
