<?php

use Slim\App;
use Root\Www\Action\HomeAction;

return function (App $app) {
    $app->map(['GET', 'POST'], '/', HomeAction::class);
};
