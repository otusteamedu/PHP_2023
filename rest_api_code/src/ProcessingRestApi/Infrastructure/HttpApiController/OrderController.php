<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\HttpApiController;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer\Response;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer\StringResponse;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\RabbitMqHelper;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase\CreateOrderUseCase;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase\UpdateOrderUseCase;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase\GetOrderStatusUseCase;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase\GetOrderResultsUseCase;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\DataMapper\OrderMapper;

class OrderController
{
    protected \PDO $pdo;
    protected RabbitMqHelper $rabbitHelper;

    public function __construct(\PDO $pdo, RabbitMqHelper $rabbitHelper)
    {
        $this->pdo = $pdo;
        $this->rabbitHelper = $rabbitHelper;
    }


    public function create(array $requestParams): Response
    {
        $createOrderUseCase = new CreateOrderUseCase(new OrderMapper($this->pdo), $this->rabbitHelper);
        $createOrderUseCase->create($requestParams);
        return new Response(true);
    }

    public function getOrderResults(array $requestParams): Response
    {
        $createOrderUseCase = new GetOrderResultsUseCase(new OrderMapper($this->pdo), $this->rabbitHelper);
        return new StringResponse(
            "file",
            $createOrderUseCase->getOrderResults($requestParams)
        );
    }

    public function getOrderStatus(array $requestParams): Response
    {
        $getOrderStatusUseCase = new GetOrderStatusUseCase(new OrderMapper($this->pdo), $this->rabbitHelper);
        return new StringResponse(
            "status",
            $getOrderStatusUseCase->getOrderStatus($requestParams)
        );
    }

    public function update(array $requestParams): Response
    {
        $updateOrderUseCase = new UpdateOrderUseCase(new OrderMapper($this->pdo), $this->rabbitHelper);
        $updateOrderUseCase->update($requestParams);
        return new Response(true);
    }
}
