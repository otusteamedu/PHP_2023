<?php

use App\Infrastructure\Http\{CreateApplicationFormAction, TestAction};
use Slim\App;

return function (App $app) {
    $app->get('/', TestAction::class)->setName('test');
    $app->post('/application_form', CreateApplicationFormAction::class);
};
