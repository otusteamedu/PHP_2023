<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper;

use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;

interface OrderMapperInterface
{
    public function findById(int $id): Order;
    public function findByStatementNumber(string $name): Order;
    public function insert(Order $order): void;
    public function update(Order $order): bool;
    public function delete(Order $order): bool;
}
