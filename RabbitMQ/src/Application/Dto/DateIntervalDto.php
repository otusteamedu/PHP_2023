<?php

namespace App\Application\Dto;

use DateTime;

readonly class DateIntervalDto
{
    public function __construct(private DateTime $dateFrom, private DateTime $dateTo)
    {
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }
}
