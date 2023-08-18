<?php

declare(strict_types=1);

use Root\App\Application\Actions\AddAction;
use Root\App\Application\Actions\ListAction;
use Root\App\Application\Actions\ViewAction;
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
