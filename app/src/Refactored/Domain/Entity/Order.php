<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\Entity;

use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Money;

final class Order
{
    public function __construct(
        private readonly Id $id,
        private readonly Client $client,
        private Money $amount,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function setAmount(Money $amount): void
    {
        $this->amount = $amount;
    }
}
