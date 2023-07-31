<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\Repository;

use Imitronov\Hw15\Refactored\Domain\Entity\Order;
use Imitronov\Hw15\Refactored\Domain\Exception\EntityNotFoundException;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;

interface OrderRepository
{
    public function nextId(): Id;

    /**
     * @throws EntityNotFoundException
     */
    public function firstOrFailById(Id $id): Order;
}
