<?php

declare(strict_types=1);

use Root\App\Actions\AddAction;
use Root\App\Actions\ListAction;
use Root\App\Actions\ViewAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return function (App $app) {
    $app->group('/request', function (RouteCollectorProxyInterface $group) {
        $group->group('', function (RouteCollectorProxyInterface $subgroup) {
            $subgroup->get('', ListAction::class);
            $subgroup->post('', AddAction::class);
        });
        $group->group(
            '/{id:[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}}',
            function (RouteCollectorProxyInterface $subgroup) {
                $subgroup->get('', ViewAction::class);
            }
        );
    });
};
