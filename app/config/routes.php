<?php

declare(strict_types=1);

use Slim\App;
use App\HomeAction;
use App\Api\InfoEvents;
use App\Api\CreateEvents;
use App\Api\DeleteEvents;
use App\Api\UpdateEvents;

return function (App $app) {

    // Home Page
    $app->get('/', HomeAction::class);

    // Api
    $app->get('/api/events[/{key}]', InfoEvents::class);
    $app->post('/api/events', CreateEvents::class);
    $app->delete('/api/events/{key}', DeleteEvents::class);
    $app->put('/api/events', UpdateEvents::class);
};
