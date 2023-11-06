<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Repository\FactoryCalendarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FactoryCalendarRepository::class)]
class FactoryCalendar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $workHours = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $calendarDays = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $workDays = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $weekendHolidaysDays = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
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

    #[ORM\PrePersist]
    public function setCreatedAtAutomatically(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAtAutomatically(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable());
    }
}
