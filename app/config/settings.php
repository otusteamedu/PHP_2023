<?php

error_reporting(E_ALL);

ini_set('display_errors', '1');

date_default_timezone_set('Europe/Moscow');

$settings = [];

$settings['root'] = dirname(__DIR__);

$settings['error'] = [

    'display_error_details' => true,

    'log_errors' => true,

    'log_error_details' => true,
];

return $settings;
