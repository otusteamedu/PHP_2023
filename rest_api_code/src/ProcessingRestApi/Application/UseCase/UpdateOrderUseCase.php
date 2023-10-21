<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\RabbitMqHelper;
use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;

class UpdateOrderUseCase
{
    protected OrderMapperInterface $orderMapper;
    protected RabbitMqHelper $rabbitHelper;

    public function __construct(
        OrderMapperInterface $orderMapper,
        RabbitMqHelper $rabbitHelper
    ) {
        $this->orderMapper = $orderMapper;
        $this->rabbitHelper = $rabbitHelper;
    }

    public function update(array $requestParams): void
    {
        // $order = $this->orderMapper->findByStatementNumber($requestParams["statementNumber"]);
        $order = $this->orderMapper->findById((int) $requestParams["id"]);
        $order->setStatus($requestParams["status"]);
        $order->setFilePath($requestParams["filePath"]);
        $this->orderMapper->update($order);
    }
}

