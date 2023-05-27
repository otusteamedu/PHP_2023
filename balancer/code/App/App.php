<?php

namespace IilyukDmitryi\App;

use IilyukDmitryi\App\Controllers\AppController;
use IilyukDmitryi\App\Statistic\StatisticSession;

class App
{
    public function run(): void
    {
        $appController = new AppController();
        $statistic = new StatisticSession();
        $appController->setStatisticEngine($statistic);
        $appController->showForm();
        if ($appController::isPost()) {
            $appController->checkEmails();
        }
        $appController->printStatisticResult();
        session_write_close();
    }
}
