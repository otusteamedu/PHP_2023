<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\RabbitMqHelper;
use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;

class CreateOrderUseCase
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

    public function create(array $requestParams): void
    {
        // $requestParams["statementNumber"] = "100000/123";
        /*
            $requestParams = [
                statementNumber
            ]


            actions:
            - check auth
            - save to postgres
            - send queue mess
        */

        $order = new Order(
            Order::FAKE_ID,
            "processing",
            $requestParams["statementNumber"]
        );
        $this->orderMapper->insert($order);

        $message = json_encode(
            [
                "id" => $order->getId(),
                "statementNumber" => $requestParams["statementNumber"]
            ],
            JSON_UNESCAPED_UNICODE
        );
        $this->rabbitHelper->addToQueue("orders", $message);
    }
}
