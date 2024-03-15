<?php

use Slim\App;

return function (App $app) {
    $app->get('/status/{requestId}', 'App\Controllers\StatusController:getStatus');
};
