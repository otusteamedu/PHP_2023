<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;

class UpdateOrderUseCase
{
    const STATEMENTS_DIRECTORY = "/data/mysite.local/statements/";

    protected OrderMapperInterface $orderMapper;

    public function __construct(
        OrderMapperInterface $orderMapper
    ) {
        $this->orderMapper = $orderMapper;
    }

    public function validateOrderId($orderId)
    {
        if (empty($orderId)) {
            throw new \Exception("Не передан обязательный параметр orderId");
        } elseif (
            !is_int($orderId)
            && (preg_match("#^\d+$#", $orderId) != 1)
        ) {
            throw new \Exception("Некорректно заполнено поле orderId");
        }
    }

    public function update(array $requestParams): void
    {
        $this->validateOrderId($requestParams["orderId"]);
        $order = $this->orderMapper->findById((int) $requestParams["orderId"]);
        $order->setStatus($requestParams["status"]);
        $order->setFilePath(self::STATEMENTS_DIRECTORY . $requestParams["fileName"]);
        $this->orderMapper->update($order);
    }
}
