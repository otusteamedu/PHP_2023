<?php

use FastRoute\RouteCollector;

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $router) {
    $router->addRoute('GET', '/channel/{id}/likes-dislikes', 'App\Controllers\StatisticsController@getTotalLikesAndDislikesForChannel');
    $router->addRoute('GET', '/top-channels/{n:\d+}', 'App\Controllers\StatisticsController@getTopChannelsByLikesToDislikesRatio');
});

return $dispatcher;
