<?php

use Slim\App;

return function (App $app) {
    $app->post('/queue', 'App\Controllers\QueueController:addToQueue');
};
