<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;

class GetOrderStatusUseCase
{
    protected OrderMapperInterface $orderMapper;
    protected Order $order;

    public function __construct(
        OrderMapperInterface $orderMapper
    ) {
        $this->orderMapper = $orderMapper;
    }

    public function loadOrderById(int $orderId)
    {
        $this->order = $this->orderMapper->findById((int) $orderId);
    }

    public function validateOrderId($orderId)
    {
        if (empty($orderId)) {
            throw new \Exception("Не передан обязательный параметр orderId");
        } elseif (preg_match("#^\d+$#", $orderId) != 1) {
            throw new \Exception("Некорректно заполнено поле orderId");
        }
    }

    public function getOrderStatus(array $requestParams): string
    {
        if (empty($this->order)) {
            $this->validateOrderId($requestParams["orderId"]);
            $this->loadOrderById((int) $requestParams["orderId"]);
        }
        return $this->order->getStatus();
    }

    public function getStatementNumber(array $requestParams): string
    {
        if (empty($this->order)) {
            $this->validateOrderId($requestParams["orderId"]);
            $this->loadOrderById((int) $requestParams["orderId"]);
        }
        return $this->order->getStatementNumber();
    }
}
