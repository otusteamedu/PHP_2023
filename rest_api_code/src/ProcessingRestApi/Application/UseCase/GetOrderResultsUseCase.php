<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\RabbitMqHelper;
use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;


class GetOrderResultsUseCase
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

    public function getOrderResults(array $requestParams): string
    {
        $order = $this->orderMapper->findById((int) $requestParams["id"]);
        header("Content-type: application/octet-stream");
        header('Content-Disposition:attachment;filename="statement.txt"');
        exit(readfile($order->getFilePath()));
       
        // return $order->getFilePath();
    }
}
