<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\Repository;

use Imitronov\Hw15\Refactored\Domain\Entity\Payment;
use Imitronov\Hw15\Refactored\Domain\Exception\EntityNotFoundException;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;

interface PaymentRepository
{
    public function nextId(): Id;

    /**
     * @throws EntityNotFoundException
     */
    public function firstOrFailById(Id $id): Payment;
}
