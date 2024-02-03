<?php

namespace App\Application\Contracts;

use DateTimeInterface;

interface ExpenseRepositoryInterface
{
    public function findByBetweenDates(DateTimeInterface $start, DateTimeInterface $end): array;
}
