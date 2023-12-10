<?php
declare(strict_types=1);

return [
    'check' => 'check/service',
    'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
    'news/([0-9]+)' => 'news/view', // actionView в NewsController
    'news' => 'news/index', // actionIndex в NewsController
];