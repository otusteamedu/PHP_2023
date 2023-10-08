<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Money;

final class Income
{
    public function __construct(
        private readonly Id $id,
        private readonly Money $amount,
        private readonly \DateTimeInterface $dateTime,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }
}
