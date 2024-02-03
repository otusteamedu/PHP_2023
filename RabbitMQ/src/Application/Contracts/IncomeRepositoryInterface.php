<?php

namespace App\Application\Contracts;

use DateTimeInterface;

interface IncomeRepositoryInterface
{
    public function findByBetweenDates(DateTimeInterface $start, DateTimeInterface $end): array;
}
