<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\RabbitMqHelper;
use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;

class GetOrderStatusUseCase
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

    public function getOrderStatus(array $requestParams): string
    {
        $order = $this->orderMapper->findById((int) $requestParams["id"]);
        return $order->getStatus();
    }
}
