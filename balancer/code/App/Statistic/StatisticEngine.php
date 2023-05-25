<?php

namespace IilyukDmitryi\App\Statistic;

interface StatisticEngine
{
    public function addStat(bool $isSuccess, string $str);

    public function printStat();
}
