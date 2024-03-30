<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Repository;

use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequest;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Repository\OrderReportRepositoryInterface;
use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\RabbitLibs\RabbitAMQPLib;

class RabbitMQQueueRepository implements OrderReportRepositoryInterface
{
    public function __construct(
        private RabbitAMQPLib $rabbitAMQPLib,
    ) {
    }

    public function save(OrderReportRequest $request): void
    {
        $this->rabbitAMQPLib->publish(serialize($request));
    }
}
