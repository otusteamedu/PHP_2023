<?php

declare(strict_types=1);

namespace LebedevVR\App\DTO;

readonly class MoviePaymentDTO
{
    public function __construct(
        private int    $cardNumber,
        private string $cardHolder,
        private string $cardExpiration,
        private int    $cvv,
        private string $orderNumber,
        private string $sum
    ) {}

    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }

    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    public function getCardExpiration(): string
    {
        return $this->cardExpiration;
    }

    public function getCvv(): int
    {
        return $this->cvv;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function getSum(): string
    {
        return $this->sum;
    }
}
