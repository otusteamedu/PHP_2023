<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Domain\Repository;

use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequest;

interface OrderReportRepositoryInterface
{
    public function save(OrderReportRequest $request): void;
}
