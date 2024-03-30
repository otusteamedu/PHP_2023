<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq;

use Gkarman\Rabbitmq\Infrastructure\RabbitMQConfigs;
use Gkarman\Rabbitmq\Modules\OrderReport\Application\GenerateReportUseCase;
use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Console\OrderReportCommand;
use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Http\OrderReportController;
use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\RabbitLibs\RabbitAMQPLib;
use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Repository\RabbitMQQueueRepository;

class App
{
    public function run()
    {
        if (!empty($_POST)) {
            $controller = new OrderReportController(
                new GenerateReportUseCase(new RabbitMQQueueRepository(new RabbitAMQPLib(new RabbitMQConfigs())))
            );
            return $controller->run($_POST);
        }

        if (!empty($_SERVER['argv'])) {
            $command = new OrderReportCommand(new RabbitMQConfigs());
            return $command->run();
        }
    }
}
