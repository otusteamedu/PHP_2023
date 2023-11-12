<?php

declare(strict_types=1);

namespace User\Php2023\Domain\ValueObject;

use DateTime;
use Exception;
use InvalidArgumentException;

class DateRange
{
    private DateTime $startDate;
    private DateTime $endDate;

    /**
     * @throws Exception
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $this->createDateTime($startDate);
        $this->endDate = $this->createDateTime($endDate);
        $this->validate();
    }

    private function createDateTime(string $date): DateTime
    {
        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateTime) {
            throw new InvalidArgumentException("Invalid date format: $date. Expected format: Y-m-d.");
        }
        return $dateTime;
    }

    private function validate(): void
    {
        if ($this->startDate > $this->endDate) {
            throw new InvalidArgumentException("Start date must be earlier than end date.");
        }
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function getStartDateAsString(): string
    {
        return $this->startDate->format('Y-m-d');
    }

    public function getEndDateAsString(): string
    {
        return $this->endDate->format('Y-m-d');
    }
}
