<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq;

use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Console\OrderReportCommand;
use Gkarman\Rabbitmq\Modules\OrderReport\Infastructure\Http\OrderReportController;

class App
{
    public function run()
    {
        if (!empty($_POST)) {
            $controller = new OrderReportController();
            return $controller->run($_POST);
        }

        if (!empty($_SERVER['argv'])) {

            $command = new OrderReportCommand();
            return $command->run();
        }
    }
}
