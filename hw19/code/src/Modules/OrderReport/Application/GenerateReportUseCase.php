<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Application;

use Gkarman\Rabbitmq\Modules\OrderReport\Application\Request\GenerateOrderRequest;
use Gkarman\Rabbitmq\Modules\OrderReport\Application\Response\GenerateReportResponse;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Entity\OrderReportRequest;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\Repository\OrderReportRepositoryInterface;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Email;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\Id;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateFrom;
use Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject\ReportDateTo;

class GenerateReportUseCase
{
    public function __construct(
        private OrderReportRepositoryInterface $repository
    ) {
    }

    public function run(GenerateOrderRequest $request): GenerateReportResponse
    {
        $orderReportRequest = new OrderReportRequest(
            new Id(1), // Получили из аутитификации, здесь захардкожено
            new ReportDateFrom($request->createDateFrom),
            new ReportDateTo($request->createDateTo),
            new Email($request->emailTo),
        );
        $this->repository->save($orderReportRequest);

        return new GenerateReportResponse("Отчет будет отправлен на email {$request->emailTo}");
    }
}
