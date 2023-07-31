<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\Entity;

use Imitronov\Hw15\Refactored\Domain\Constant\PaymentStatus;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Money;

final class Payment
{
    public function __construct(
        private readonly Id $id,
        private readonly Order $order,
        private readonly Money $amount,
        private ?Id $transactionId,
        private PaymentStatus $status,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getTransactionId(): ?Id
    {
        return $this->transactionId;
    }

    public function setTransactionId(?Id $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getStatus(): PaymentStatus
    {
        return $this->status;
    }

    public function setStatus(PaymentStatus $status): void
    {
        $this->status = $status;
    }
}
