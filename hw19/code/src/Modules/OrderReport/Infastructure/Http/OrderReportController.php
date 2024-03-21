<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Http;

use Gkarman\Rabbitmq\Modules\OrderReport\Application\GenerateReportUseCase;
use Gkarman\Rabbitmq\Modules\OrderReport\Application\Request\GenerateOrderRequest;
use Gkarman\Rabbitmq\Modules\OrderReport\Application\Response\GenerateReportResponse;
use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Repository\RabbitMQQueueRepository;

class OrderReportController
{
    public function run(array $request): string
    {
        try {
            $generateOrderRequest = GenerateOrderRequest::createFromArray($request);
            $useCase = new GenerateReportUseCase(new RabbitMQQueueRepository());
            $response = $useCase->run($generateOrderRequest);
        } catch (\Exception $e) {
            $response = new GenerateReportResponse($e->getMessage());
        }

        return $response->message;
    }
}
