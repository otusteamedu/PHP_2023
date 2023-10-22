<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\RabbitMqHelperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;

class CreateOrderUseCase
{
    protected OrderMapperInterface $orderMapper;
    protected RabbitMqHelperInterface $rabbitHelper;

    public function __construct(
        OrderMapperInterface $orderMapper,
        RabbitMqHelperInterface $rabbitHelper
    ) {
        $this->orderMapper = $orderMapper;
        $this->rabbitHelper = $rabbitHelper;
    }

    public function create(array $requestParams): int
    {
        if (empty($requestParams["statementNumber"])) {
            throw new \Exception("Не передан обязательный параметр statementNumber");
        } elseif (preg_match("#100000\/\d{3,15}#", $requestParams["statementNumber"]) != 1) {
            throw new \Exception("Некорректно заполнено поле statementNumber");
        }

        $order = new Order(
            Order::FAKE_ID,
            "processing",
            $requestParams["statementNumber"]
        );
        $this->orderMapper->insert($order);

        $message = json_encode(
            [
                "orderId" => $order->getId(),
                "statementNumber" => $requestParams["statementNumber"]
            ],
            JSON_UNESCAPED_UNICODE
        );
        $this->rabbitHelper->addToQueue("orders", $message);

        return $order->getId();
    }
}
