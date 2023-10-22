<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\UseCase;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;


class GetOrderResultsUseCase
{
    protected OrderMapperInterface $orderMapper;

    public function __construct(
        OrderMapperInterface $orderMapper
    ) {
        $this->orderMapper = $orderMapper;
    }

    public function getOrderResults(array $requestParams): string
    {
        if (empty($requestParams["orderId"])) {
            throw new \Exception("Не передан обязательный параметр orderId");
        } elseif (preg_match("#^\d+$#", $requestParams["orderId"]) != 1) {
            throw new \Exception("Некорректно заполнено поле orderId");
        }

        $order = $this->orderMapper->findById((int) $requestParams["orderId"]);
        if ($order->getStatus() != "completed") {
            throw new \Exception("Документ еще не готов.");
        }
        if (!file_exists($order->getFilePath())) {
            throw new \Exception("Запрошенный документ не найден на диске.");
        }
        header("Content-type: application/octet-stream");
        header('Content-Disposition:attachment;filename="statement.txt"');
        exit(readfile($order->getFilePath()));
    }
}
