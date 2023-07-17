<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->addRoute('GET', '/statistics', 'App\Controllers\StatisticsController@showStatistics');
    $r->addRoute('GET', '/top-channels', 'App\Controllers\StatisticsController@topChannels');
};
