<?php

namespace IilyukDmitryi\App\Statistic;

class View
{
    public static function show(array $statistic)
    {
        $arrIp = array_keys($statistic);
        $arrHosts = array_keys(array_merge(...array_values($statistic)));
        $currResult = end($_SESSION['StatisticController'][$_ENV['SERVER_ADDR']][$_ENV['HOSTNAME']]);
        include "Template/Table.php";
    }
}
