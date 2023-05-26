<?php

namespace IilyukDmitryi\App;

use IilyukDmitryi\App\Controllers\AppController;
use IilyukDmitryi\App\Statistic\StatisticSession;

class App
{
    public function run(): void
    {
        session_start();
        $appController = new AppController();
        $statistic = new StatisticSession();
        $appController->setStatisticEngine($statistic);
        $appController->checkStringPost();
        session_write_close();
    }
}
