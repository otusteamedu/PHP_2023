<?php

namespace IilyukDmitryi\App\Statistic;

class StatisticSession implements StatisticEngine
{
    /**
     * @param bool $isSuccess
     * @param string $str
     * @return void
     */
    public function addStat(bool $isSuccess, string $str): void
    {
        $_SESSION['StatisticController'][$_ENV['SERVER_ADDR']][$_ENV['HOSTNAME']][] = $str;
    }

    public function printStat(): void
    {
        if (!isset($_SESSION['StatisticController'])) {
            return;
        }
        View::show($_SESSION['StatisticController']);
    }
}
