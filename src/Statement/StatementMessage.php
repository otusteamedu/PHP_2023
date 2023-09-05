<?php

declare(strict_types=1);

namespace App\Statement;

final readonly class StatementMessage
{
    public function __construct(
        private \DateTimeInterface $dateFrom,
        private \DateTimeInterface $dateTo,
    ) {
    }

    public function getDateFrom(): \DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function getDateTo(): \DateTimeInterface
    {
        return $this->dateTo;
    }
}
